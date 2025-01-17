<?php

require_once(__DIR__ . "/../models/HairdresserModel.php");

class HairdresserController
{
    private $hairdresserModel;

    public function __construct()
    {
        $this->hairdresserModel = new HairdresserModel();
    }

    public function listAll()
    {
        $hairdressers = $this->hairdresserModel->getAll();
        require(__DIR__ . "/../views/hairdressers/list.php");
    }

    public function show($id)
    {
        $hairdresser = $this->hairdresserModel->getById($id);
        require(__DIR__ . "/../views/hairdressers/show.php");
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // handle form submission
            $data = [
                'email' => $_POST['email'],
                'name' => $_POST['name'],
                'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
                'phone_number' => $_POST['phone_number'],
                'address' => $_POST['address'],
                'profile_picture' => $_POST['profile_picture'],
                'specialization' => $_POST['specialization']
            ];
            $this->hairdresserModel->create($data);
            // redirect or confirm
        } else {
            require(__DIR__ . "/../views/hairdressers/create_form.php");
        }
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'email' => $_POST['email'],
                'name' => $_POST['name'],
                'phone_number' => $_POST['phone_number'],
                'address' => $_POST['address'],
                'profile_picture' => $_POST['profile_picture'],
                'specialization' => $_POST['specialization']
            ];
            $this->hairdresserModel->update($id, $data);
            // redirect or confirm
        } else {
            // GET request, load form with existing data
            $hairdresser = $this->hairdresserModel->getById($id);
            require(__DIR__ . "/../views/hairdressers/edit_form.php");
        }
    }

    public function delete($id)
    {
        $this->hairdresserModel->delete($id);
        // redirect or confirm
    }
}
