<?php
require_once(__DIR__ . '/../lib/Validator.php');
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
            $validator = new Validator();

            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            $validator->validateEmail($email)
                    ->validateRequired('password', $password, 'Password');

            if ($validator->hasErrors()) {
                $errors = $validator->getErrors();
                require(__DIR__ . '/../views/auth/login.php');
                return;
            }

            // 1) Check 'users' table
            $user = $this->userModel->getByEmail($email);
            if ($user && password_verify($password, $user['password'])) {
                // If user is found
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['is_admin'] = ($user['is_admin'] == 1);

                header("Location: /"); // or /admin if admin
                exit;
            }

            // 2) If not in 'users', check 'hairdressers'
            $hairdresser = $this->hairdresserModel->getByEmail($email);
            if ($hairdresser && password_verify($password, $hairdresser['password'])) {
                $_SESSION['hairdresser_id'] = $hairdresser['id'];
                header("Location: /hairdressers");
                exit;
            }

            // 3) Otherwise, error
            $error = "Invalid email or password.";
        }
        require(__DIR__ . '/../views/auth/login.php');
    }

    // Show the register form (GET) or handle registration (POST)
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $validator = new Validator();

            $email          = trim($_POST['email'] ?? '');
            $username       = trim($_POST['username'] ?? '');
            $password       = $_POST['password'] ?? '';
            $phoneNumber    = trim($_POST['phone_number'] ?? '');
            $address        = trim($_POST['address'] ?? '');
            $profilePicture = trim($_POST['profile_picture'] ?? '');
            $isAdminInput   = $_POST['is_admin'] ?? null;

            // Validations using your Validator helper

            // 1. Email must be valid
            $validator->validateEmail($email);

            // 2. Username must be at least 3 chars
            $validator->validateUsername($username, 3);

            // 3. Password must be at least 6 chars
            $validator->validatePassword($password, 6);

            // 4. Phone number is optional, but if provided, must contain only digits
            if (!empty($phoneNumber)) {
                $validator->validatePhoneNumber($phoneNumber);
            }

            // 5. Address is optional, but let's limit to 200 chars
            // Adjust as needed
            if (!empty($address)) {
                $validator->validateMaxLength('address', $address, 200, 'Address');
            }

            // Check for errors
            if ($validator->hasErrors()) {
                $errors = $validator->getErrors();
                require(__DIR__ . '/../views/auth/register.php');
                return;
            }

            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert into users table only
            // (since no "hairdresser" role is allowed for self-registration)
            $data = [
                'email'    => $email,
                'username' => $username,
                'password' => $hashedPassword,
                'phone_number' => $_POST['phone_number'] ?? null,
                'address' => $_POST['address'] ?? null,
                'profile_picture' => $_POST['profile_picture'] ?? null,
                'is_admin' => !empty($_POST['is_admin']) ? 1 : 0
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
