<?php

require_once(__DIR__ . "/../models/AppointmentModel.php");
require_once(__DIR__ . "/../models/UserModel.php");
require_once(__DIR__ . "/../models/HairdresserModel.php");
// Import your Auth helpers so we can call requireUser(), etc.
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
     * Display a FullCalendar page for customers to create appointments.
     * Only logged-in users can view this page.
     */
    public function calendar()
    {
        requireUser();  // Customers must be logged in

        // Show the calendar, where they can select a day/time
        require(__DIR__ . '/../views/appointments/calendar.php');
    }

    /**
     * Return JSON of existing appointments for FullCalendar.
     * Optionally filter by hairdresser or user if you prefer.
     */
    public function getCalendarEvents()
    {
        requireUser();  // Must be logged in to see events (optional choice)

        // Retrieve appointments. 
        $appointments = $this->appointmentModel->getAll();

        // Convert DB appointments into FullCalendar event objects
        $events = [];
        foreach ($appointments as $apt) {
            $start = $apt['appointment_date'] . 'T' . $apt['appointment_time'];
            $events[] = [
                'id'    => $apt['id'],
                'title' => 'Apt #' . $apt['id'] . ' (HD ' . $apt['hairdresser_id'] . ')', 
                'start' => $start,
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($events);
    }

    /**
     * Create a new appointment from the calendar selection (AJAX).
     * Real-world scenario: Only logged-in *customers* can do this.
     */
    public function createFromCalendar()
    {

        requireUser();  // Must be a logged-in user

        header('Content-Type: application/json');

        // We expect POST data: date, time, and hairdresser_id
        $date = $_POST['date'] ?? null; 
        $time = $_POST['time'] ?? null;
        $hairdresserId = $_POST['hairdresser_id'] ?? null;

        // Get user ID from session
        $userId = $_SESSION['user_id'];

        // Validate
        if (!$date || !$time || !$hairdresserId) {
            echo json_encode(['success' => false, 'message' => 'Missing required fields.']);
            return;
        }

        // Check if that slot is already taken for that hairdresser
        $existing = $this->appointmentModel->findByHairdresserDateTime($hairdresserId, $date, $time);
        if ($existing) {
            echo json_encode(['success' => false, 'message' => 'That time slot is already booked!']);
            return;
        }

        // Create the appointment
        $data = [
            'user_id'         => $userId,
            'hairdresser_id'  => $hairdresserId,
            'appointment_date' => $date,
            'appointment_time' => $time,
            'status'           => 'upcoming'
        ];
        error_log(print_r($data, true), 3, "logs/debug.log");

        $newId = $this->appointmentModel->create($data);


        if ($newId) {
            echo json_encode([
                'success' => true,
                'message' => 'Appointment created successfully.',
                'appointment_id' => $newId
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to create appointment.']);
        }
    }

    /**
     * Show a list of all appointments (for staff or admin).
     * Example usage with requireHairdresser() or requireAdmin().
     * Adjust based on your real-world scenario.
     */
    public function listAll()
    {
        // Suppose only hairdressers can see *all* appointments
        requireHairdresser(); 
        $appointments = $this->appointmentModel->getAll();
        require(__DIR__ . "/../views/appointments/list.php");
    }

    /**
     * Create Appointment - (if staff can create them manually).
     * Example usage: requireHairdresserAndUser() if you want staff or user only.
     */
    public function createAppointment()
    {
        requireHairdresserAndUser(); 
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'user_id' => $_POST['user_id'],
                'hairdresser_id' => $_POST['hairdresser_id'],
                'appointment_date' => $_POST['appointment_date'],
                'appointment_time' => $_POST['appointment_time'],
                'status' => 'upcoming'
            ];
            $newId = $this->appointmentModel->create($data);
            header("Location: /appointments");
            exit;
        }

        $allUsers = $this->userModel->getAll();
        $allHairdressers = $this->hairdresserModel->getAll();
        require(__DIR__ . "/../views/appointments/create_form.php");
    }

    /**
     * Edit Appointment - staff usage or user usage depending on your rules
     */
    public function editAppointment($id)
    {
        requireHairdresser(); // e.g., only staff can edit

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'user_id'        => $_POST['user_id'],
                'hairdresser_id' => $_POST['hairdresser_id'],
                'appointment_date' => $_POST['appointment_date'],
                'appointment_time' => $_POST['appointment_time'],
                'status'         => $_POST['status']
            ];
            $this->appointmentModel->update($id, $data);
            header("Location: /appointments");
            exit;
        } else {
            $appointment = $this->appointmentModel->getById($id);
            $allUsers = $this->userModel->getAll();
            $allHairdressers = $this->hairdresserModel->getAll();
            require(__DIR__ . "/../views/appointments/edit_form.php");
        }
    }

    /**
     * Delete Appointment - staff usage or user usage depending on your rules
     */
    public function deleteAppointment($id)
    {
        requireHairdresser(); // or requireAdmin(), etc.
        $this->appointmentModel->delete($id);
        header("Location: /appointments");
        exit;
    }
}