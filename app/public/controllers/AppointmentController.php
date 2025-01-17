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

    public function listAll()
    {
        // Could show all appointments or filter by user/hairdresser
        $appointments = $this->appointmentModel->getAll();
        // Load a view to display them
        require(__DIR__ . "/../views/appointments/list.php");
    }

    public function createAppointment()
    {
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
