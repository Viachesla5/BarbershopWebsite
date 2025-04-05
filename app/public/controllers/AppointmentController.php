<?php

require_once(__DIR__ . "/../models/AppointmentModel.php");
require_once(__DIR__ . "/../models/UserModel.php");
require_once(__DIR__ . "/../models/HairdresserModel.php");
require_once(__DIR__ . "/../lib/Auth.php");

class AppointmentController
{
    private $appointmentModel;
    private $userModel;
    private $hairdresserModel;

    public function __construct()
    {
        $this->appointmentModel = new AppointmentModel();
        $this->userModel = new UserModel();
        $this->hairdresserModel = new HairdresserModel();
    }

    /**
     * Display the calendar view for logged-in users
     */
    public function calendar()
    {
        requireUser();  // Must be logged in to see calendar
        require(__DIR__ . '/../views/appointments/calendar.php');
    }

    /**
     * Return JSON events for FullCalendar, showing hairdresser name, user name, etc.
     */
    public function getCalendarEvents()
    {
        requireUser();  // Must be logged in

        // Get the logged-in user's ID
        $userId = $_SESSION['user_id'];

        // We'll retrieve appointments with hairdresser & user names, filtered by user ID
        $appointments = $this->appointmentModel->getAllWithNames(['user_id' => $userId]);

        $events = [];
        foreach ($appointments as $apt) {
            // Combine date & time into a start
            $start = $apt['appointment_date'] . 'T' . $apt['appointment_time'];

            $userName = $apt['user_name'];
            $hdName   = $apt['hairdresser_name'];
            
            // Format time to show AM/PM
            $formattedTime = date('g:i A', strtotime($apt['appointment_time']));

            $title = "With: $hdName at $formattedTime";

            $events[] = [
                'id' => $apt['id'],
                'title' => $title,
                'start' => $start,
                'backgroundColor' => '#3B82F6', // Blue color for user's appointments
                'borderColor' => '#2563EB',
                'textColor' => '#FFFFFF',
                'extendedProps' => [
                    'userName' => $userName,
                    'hairdresserName' => $hdName,
                    'status' => $apt['status']
                ]
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($events);
    }

    /**
     * Create appointment from calendar selection (AJAX), with 30-min rule enforced.
     */
    public function createFromCalendar()
    {
        requireUser();

        header('Content-Type: application/json');

        $date = filter_var($_POST['date'], FILTER_SANITIZE_SPECIAL_CHARS) ?? null; 
        $time = filter_var($_POST['time'], FILTER_SANITIZE_SPECIAL_CHARS) ?? null;
        $hairdresserId = filter_var($_POST['hairdresser_id'], FILTER_SANITIZE_NUMBER_INT) ?? null;
        $userId = filter_var($_SESSION['user_id'], FILTER_SANITIZE_NUMBER_INT) ?? null;

        // Validate fields
        if (!$date || !$time || !$hairdresserId || !$userId) {
            echo json_encode(['success' => false, 'message' => 'Missing required fields.']);
            return;
        }

        // Check 30-min rule. If any apt is within 30 min, we block it:
        $existing = $this->appointmentModel->findByHairdresserDateTime($hairdresserId, $date, $time);
        if ($existing) {
            echo json_encode([
                'success' => false,
                'message' => 'That time slot is already booked (appointment lasts at least 30-min).'
            ]);
            return;
        }

        // Create
        $data = [
            'user_id'         => $userId,
            'hairdresser_id'  => $hairdresserId,
            'appointment_date' => $date,
            'appointment_time' => $time,
            'status'           => 'upcoming'
        ];
        $newId = $this->appointmentModel->create($data);
        if ($newId) {
            echo json_encode(['success' => true, 'message' => 'Appointment created successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to create appointment.']);
        }
    }

    /**
     * Show a list of all appointments (for staff)
     */
    public function listAll()
    {
        requireHairdresser();
        $appointments = $this->appointmentModel->getAllWithNames();
        // Optionally pass $appointments to a list view
        require(__DIR__ . "/../views/appointments/list.php");
    }

    /**
     * NEW METHOD:
     * Show a confirmation page to delete an appointment.
     * (GET /appointments/delete/{id})
     */
    public function deleteConfirm($id)
    {
        requireHairdresser(); // or requireAdmin() if only admins can delete
        $appointment = $this->appointmentModel->getById($id);

        if (!$appointment) {
            // No appointment found. Redirect or show error.
            header("Location: /appointments");
            exit;
        }

        // Pass appointment to view for a user-friendly message
        require(__DIR__ . "/../views/appointments/delete_confirm.php");
    }

    /**
     * NEW METHOD:
     * Perform the actual deletion after confirmation.
     * (POST /appointments/deleteConfirm/{id})
     */
    public function deleteAppointment($id)
    {
        requireHairdresser(); // or requireAdmin(), depending on your logic
        $this->appointmentModel->delete($id);

        // After deletion, redirect to the list or calendar
        header("Location: /appointments");
        exit;
    }

    /**
     * Delete appointment from a FullCalendar click (AJAX).
     * Route: POST /appointments/deleteFromCalendar
     */
    public function deleteFromCalendar()
    {
        requireUser(); // Ensure the user is logged in

        header('Content-Type: application/json');

        // Validate the 'id' field
        $id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);
        if (!$id) {
            echo json_encode(['success' => false, 'message' => 'Invalid appointment ID.']);
            return;
        }

        // Fetch the appointment to verify it exists
        $appointment = $this->appointmentModel->getById($id);

        if (!$appointment) {
            echo json_encode(['success' => false, 'message' => 'Appointment not found.']);
            return;
        }

        // Ensure the logged-in user is the owner of the appointment
        if ($appointment['user_id'] != $_SESSION['user_id']) {
            echo json_encode(['success' => false, 'message' => 'Not authorized to delete this appointment.']);
            return;
        }

        // Perform the delete
        $this->appointmentModel->delete($id);

        echo json_encode(['success' => true, 'message' => 'Appointment deleted successfully.']);
    }

    /**
     * Handle editing an appointment
     * GET: Show the edit form
     * POST: Process the form submission
     */
    public function editAppointment($id)
    {
        requireHairdresser(); // or requireAdmin() if only admins can edit

        // Get the appointment data
        $appointment = $this->appointmentModel->getById($id);
        if (!$appointment) {
            header("Location: /appointments");
            exit;
        }

        // Get lists for dropdowns
        $users = $this->userModel->getAll();
        $hairdressers = $this->hairdresserModel->getAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = [];

            // Validate and sanitize input
            $userId = filter_var($_POST['user_id'], FILTER_VALIDATE_INT);
            $hairdresserId = filter_var($_POST['hairdresser_id'], FILTER_VALIDATE_INT);
            $date = filter_var($_POST['appointment_date'], FILTER_SANITIZE_SPECIAL_CHARS);
            $time = filter_var($_POST['appointment_time'], FILTER_SANITIZE_SPECIAL_CHARS);
            $status = filter_var($_POST['status'], FILTER_SANITIZE_SPECIAL_CHARS);

            // Validate required fields
            if (!$userId || !$hairdresserId || !$date || !$time) {
                $errors[] = "All fields are required.";
            }

            // Validate date is not in the past
            $appointmentDateTime = strtotime($date . ' ' . $time);
            if ($appointmentDateTime < time()) {
                $errors[] = "Appointment date and time cannot be in the past.";
            }

            // Check for conflicts with other appointments
            $existing = $this->appointmentModel->findByHairdresserDateTime($hairdresserId, $date, $time);
            if ($existing && $existing['id'] != $id) {
                $errors[] = "This time slot is already booked.";
            }

            if (empty($errors)) {
                $data = [
                    'user_id' => $userId,
                    'hairdresser_id' => $hairdresserId,
                    'appointment_date' => $date,
                    'appointment_time' => $time,
                    'status' => $status
                ];

                if ($this->appointmentModel->update($id, $data)) {
                    header("Location: /appointments");
                    exit;
                } else {
                    $errors[] = "Failed to update appointment.";
                }
            }
        }

        // Show the edit form
        require(__DIR__ . "/../views/appointments/edit.php");
    }
}
