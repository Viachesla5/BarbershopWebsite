<?php

require_once(__DIR__ . "/../models/UserModel.php");
require_once(__DIR__ . "/../lib/Auth.php");

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

    // API endpoint for deleting users
    public function deleteUser($id)
    {
        // Ensure only admins can delete users
        if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
            header('Content-Type: application/json');
            http_response_code(403);
            echo json_encode(['success' => false, 'message' => 'Unauthorized: Only admins can delete users']);
            exit;
        }

        // Check if user exists
        $user = $this->userModel->getById($id);
        if (!$user) {
            header('Content-Type: application/json');
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'User not found']);
            exit;
        }

        // Delete the user
        $result = $this->userModel->delete($id);

        header('Content-Type: application/json');
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'User deleted successfully']);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Failed to delete user']);
        }
    }
}
