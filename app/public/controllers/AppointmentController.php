<?php

require_once(__DIR__ . "/../models/AppointmentModel.php");
require_once(__DIR__ . "/../models/UserModel.php");
require_once(__DIR__ . "/../models/HairdresserModel.php");

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

    public function calendar()
    {
        // Possibly require user or hairdresser or admin login
        // requireUser(); // if you want only logged-in users

        // Load the view that contains FullCalendar
        require(__DIR__ . '/../views/appointments/calendar.php');
    }

    // 2. Return JSON of existing appointments
    public function getCalendarEvents()
    {
        // Retrieve appointments (for example, all future appointments or user-specific)
        // Example: $appointments = $this->appointmentModel->getAllUpcoming();
        $appointments = $this->appointmentModel->getAll(); // Replace with your own logic

        // Build FullCalendar event objects:
        // FullCalendar expects [{ title, start, end }, ...]
        // If you store date & time separately, you need to combine them
        $events = [];
        foreach ($appointments as $apt) {
            // Example: apt['appointment_date'] + apt['appointment_time']
            $start = $apt['appointment_date'] . 'T' . $apt['appointment_time']; 
            // If you have an end time, or set a default 1 hour:
            // $end = $apt['appointment_date'] . 'T' . calculateEndTime($apt['appointment_time']);
            // For now, let's skip the end time or set it the same as start
            $events[] = [
                'id'    => $apt['id'],
                'title' => 'Apt #' . $apt['id'],  // or $apt['user_id'] or something else
                'start' => $start,
                // 'end' => $end
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($events);
    }

    // 3. Create a new appointment from calendar selection
    public function createFromCalendar()
    {
        // Ensure user is logged in if needed
        // requireUser();

        // Read POST data (start date/time, maybe end date/time)
        $start = $_POST['start'] ?? null; 
        // $end = $_POST['end'] ?? null; // If you have an end

        // Convert $start into date/time fields or store as is
        // Example: "2025-02-10T14:00:00"
        if ($start) {
            // parse date/time
            $dateTime = explode('T', $start);
            $date = $dateTime[0]; // e.g., "2025-02-10"
            $time = $dateTime[1]; // e.g., "14:00:00"

            // Create the appointment record
            $data = [
                'user_id' => 1, // or $_SESSION['user_id'] if specific user
                'hairdresser_id' => 2, // static or pass from form if needed
                'appointment_date' => $date,
                'appointment_time' => $time,
                'status' => 'upcoming'
            ];
            $this->appointmentModel->create($data);

            // Return success response
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'message' => 'Appointment created']);
            return;
        }

        // If invalid data
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Invalid start time']);
    }



    
    public function listAll()
    {
        requireHairdresser();

        // Could show all appointments or filter by user/hairdresser
        $appointments = $this->appointmentModel->getAll();
        // Load a view to display them
        require(__DIR__ . "/../views/appointments/list.php");
    }

    public function createAppointment()
    {
        requireHairdresserAndUser();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Handle creation
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

        // -- GET REQUEST: Show form --
        // 1. Fetch all users and hairdressers from DB
        $allUsers = $this->userModel->getAll();
        $allHairdressers = $this->hairdresserModel->getAll();

        // 2. Pass them to the view
        require(__DIR__ . "/../views/appointments/create_form.php");
    }

    public function editAppointment($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Handle update
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
            // -- GET REQUEST: Load existing data --
            $appointment = $this->appointmentModel->getById($id);

            // Fetch all users and hairdressers for dropdowns
            $allUsers = $this->userModel->getAll();
            $allHairdressers = $this->hairdresserModel->getAll();

            // Pass everything to edit_form.php
            require(__DIR__ . "/../views/appointments/edit_form.php");
        }
    }

    public function deleteAppointment($id)
    {
        $this->appointmentModel->delete($id);
        // redirect or show confirmation
    }
}
