<?php

require_once(__DIR__ . "/../models/UserModel.php");
require_once(__DIR__ . "/../models/HairdresserModel.php");

class AuthController
{
    private $userModel;
    private $hairdresserModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->hairdresserModel = new HairdresserModel();
    }

    // Show the login form (GET) or handle login submission (POST)
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            // 1) Check in the users table
            $user = $this->userModel->getByEmail($email);
            if ($user && password_verify($password, $user['password'])) {
                // Valid login as a customer
                $_SESSION['user_id'] = $user['id'];

                header("Location: /");
                exit;
            }

            // 2) If not found in users, check the hairdressers table
            $hairdresser = $this->hairdresserModel->getByEmail($email);
            if ($hairdresser && password_verify($password, $hairdresser['password'])) {
                // Valid login as a hairdresser
                $_SESSION['hairdresser_id'] = $hairdresser['id'];

                // Redirect to a hairdresser dashboard or home
                header("Location: /hairdressers");
                exit;
            }

            // 3) If neither user nor hairdresser matched, set an error message
            $error = "Invalid email or password.";
        }

        // GET request (or error on POST)
        require(__DIR__ . "/../views/auth/login.php");
    }

    // Show the register form (GET) or handle registration (POST)
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email    = $_POST['email'] ?? '';
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert into users table only
            // (since no "hairdresser" role is allowed for self-registration)
            $data = [
                'email'    => $email,
                'username' => $username,
                'password' => $hashedPassword
            ];
            $this->userModel->create($data);

            // Possibly auto-login or just redirect to login page
            header("Location: /login");
            exit;
        }

        // If GET, load the registration form
        require(__DIR__ . "/../views/auth/register.php");
    }

    public function logout()
    {
        session_unset();
        session_destroy();
        header("Location: /");
        exit;
    }
}
