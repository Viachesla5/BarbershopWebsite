<?php

require_once(__DIR__ . "/../models/UserModel.php");

class UserController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    // Show a list of all users
    public function getAll()
    {
        // This calls the method we just added in UserModel
        $users = $this->userModel->getAll();

        // Then load a view file to display them, for example:
        require(__DIR__ . "/../views/pages/users.php");
    }

    // Show details for a single user
    public function get($id)
    {
        $user = $this->userModel->getById($id);
        require(__DIR__ . "/../views/pages/user.php");
    }

    // (Optional) show user creation form, process creation, etc.
    // public function create() { ... }
    // public function update($id) { ... }
    // public function delete($id) { ... }
}
