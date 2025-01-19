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

        // We'll retrieve appointments with hairdresser & user names
        $appointments = $this->appointmentModel->getAllWithNames();

        $events = [];
        foreach ($appointments as $apt) {
            // Combine date & time into a start
            $start = $apt['appointment_date'] . 'T' . $apt['appointment_time'];

            // Create a user-friendly title, e.g.:
            // "Doe (Hairdresser: Mary) at HH:MM" – or any format you like
            // We'll display hairdresser_name, user_name, or anything else
            $userName = $apt['user_name'];
            $hdName   = $apt['hairdresser_name'];
            // For time, FullCalendar already uses 'start' for the date/time
            // but we might put it in the title or just display hairdresser + user

            $title = "User: $userName, HD: $hdName";

            $events[] = [
                'id'    => $apt['id'],
                'title' => $title,    // The event label
                'start' => $start,    // Full datetime, e.g., 2025-01-19T07:00:00
                // If you want an 'end', define it (like +30 min or a set duration)
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

        $date = $_POST['date'] ?? null; 
        $time = $_POST['time'] ?? null;
        $hairdresserId = $_POST['hairdresser_id'] ?? null;
        $userId = $_SESSION['user_id'] ?? null;

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
     * Show a list of all appointments (for staff).
     */
    public function listAll()
    {
        requireHairdresser();
        $appointments = $this->appointmentModel->getAllWithNames();
        // Optionally pass $appointments to a list view
        require(__DIR__ . "/../views/appointments/list.php");
    }

    /**
     * Create Appointment - staff/manual creation
     */
    // public function createAppointment()
    // {
    //     requireHairdresserAndUser();
    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         $data = [
    //             'user_id' => $_POST['user_id'],
    //             'hairdresser_id' => $_POST['hairdresser_id'],
    //             'appointment_date' => $_POST['appointment_date'],
    //             'appointment_time' => $_POST['appointment_time'],
    //             'status' => 'upcoming'
    //         ];
    //         $newId = $this->appointmentModel->create($data);
    //         header("Location: /appointments");
    //         exit;
    //     }

    //     $allUsers = $this->userModel->getAll();
    //     $allHairdressers = $this->hairdresserModel->getAll();
    //     require(__DIR__ . "/../views/appointments/create_form.php");
    // }

    // /**
    //  * Edit Appointment - staff usage
    //  */
    // public function editAppointment($id)
    // {
    //     requireHairdresser();

    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         $data = [
    //             'user_id'        => $_POST['user_id'],
    //             'hairdresser_id' => $_POST['hairdresser_id'],
    //             'appointment_date' => $_POST['appointment_date'],
    //             'appointment_time' => $_POST['appointment_time'],
    //             'status'         => $_POST['status']
    //         ];
    //         $this->appointmentModel->update($id, $data);
    //         header("Location: /appointments");
    //         exit;
    //     } else {
    //         $appointment = $this->appointmentModel->getById($id);
    //         $allUsers = $this->userModel->getAll();
    //         $allHairdressers = $this->hairdresserModel->getAll();
    //         require(__DIR__ . "/../views/appointments/edit_form.php");
    //     }
    // }

    // /**
    //  * Delete Appointment - staff usage
    //  */
    // public function deleteAppointment($id)
    // {
    //     requireHairdresser();
    //     $this->appointmentModel->delete($id);
    //     header("Location: /appointments");
    //     exit;
    // }
}
