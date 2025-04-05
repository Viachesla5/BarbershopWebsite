<?php
require_once(__DIR__ . '/../lib/Validator.php');
require_once(__DIR__ . "/../models/UserModel.php");
require_once(__DIR__ . "/../models/HairdresserModel.php");
require_once(__DIR__ . '/../lib/Security.php');
require_once(__DIR__ . '/../models/BaseModel.php');

class AuthController extends BaseModel
{
    private $userModel;
    private $hairdresserModel;

    public function __construct()
    {
        parent::__construct();
        $this->userModel = new UserModel();
        $this->hairdresserModel = new HairdresserModel();
    }
    
    // Show the login form (GET) or handle login submission (POST)
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $validator = new Validator();
            $errors = [];

            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            try {
                $validator->validateEmail($email);
                $validator->validateRequired('password', $password, 'Password');

                if ($validator->hasErrors()) {
                    throw new Exception($validator->getErrors()[0]);
                }

                // 1) Check 'users' table
                $user = $this->userModel->getByEmail($email);
                if ($user && password_verify($password, $user['password'])) {
                    // If user is found
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['is_admin'] = ($user['is_admin'] == 1);
                    $_SESSION['success'] = "Welcome back, " . htmlspecialchars($user['username']) . "!";
                    header("Location: /"); // or /admin if admin
                    exit;
                }

                // 2) If not in 'users', check 'hairdressers'
                $hairdresser = $this->hairdresserModel->getByEmail($email);
                if ($hairdresser && password_verify($password, $hairdresser['password'])) {
                    $_SESSION['hairdresser_id'] = $hairdresser['id'];
                    $_SESSION['success'] = "Welcome back, " . htmlspecialchars($hairdresser['name']) . "!";
                    header("Location: /hairdressers");
                    exit;
                }

                // 3) Otherwise, error
                throw new Exception("Invalid email or password.");
            } catch (Exception $e) {
                $errors[] = $e->getMessage();
            }
        }
        require(__DIR__ . '/../views/auth/login.php');
    }

    // Show the register form (GET) or handle registration (POST)
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->render('auth/register');
            return;
        }

        $security = Security::getInstance();
        $errors = [];

        try {
            // Validate CSRF token
            if (!$security->validateCSRFToken($_POST['csrf_token'] ?? '')) {
                throw new Exception('Invalid security token. Please try again.');
            }

            // Check rate limit
            if (!$security->checkRateLimit('register', $_SERVER['REMOTE_ADDR'])) {
                throw new Exception('Too many registration attempts. Please try again later.');
            }

            // Sanitize and validate inputs
            $email = $security->sanitizeInput($_POST['email'] ?? '');
            $username = $security->sanitizeInput($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';
            $phoneNumber = $security->sanitizeInput($_POST['phone_number'] ?? '');
            $address = $security->sanitizeInput($_POST['address'] ?? '');

            // Validate required fields
            if (empty($email) || empty($username) || empty($password) || empty($confirmPassword)) {
                throw new Exception('Email, username, and password are required.');
            }

            // Validate password match
            if ($password !== $confirmPassword) {
                throw new Exception('Passwords do not match.');
            }

            // Validate email format
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new Exception('Invalid email format.');
            }

            // Check if email exists in either table
            if ($this->userModel->getByEmail($email)) {
                throw new Exception('Email is already registered.');
            }
            if ($this->hairdresserModel->getByEmail($email)) {
                throw new Exception('Email is already registered.');
            }

            // Validate username length
            if (strlen($username) < 3) {
                throw new Exception('Username must be at least 3 characters long.');
            }

            // Validate password strength
            $security->validatePasswordStrength($password);

            // Validate phone number if provided
            if (!empty($phoneNumber)) {
                if (!preg_match('/^[0-9]{10}$/', $phoneNumber)) {
                    throw new Exception('Phone number must be 10 digits.');
                }
            }

            // Create user
            $userData = [
                'email' => $email,
                'username' => $username,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'phone_number' => $phoneNumber ?: null,
                'address' => $address ?: null,
                'is_admin' => 0
            ];

            $this->userModel->create($userData);
            
            // Set success message and redirect
            $_SESSION['success'] = "Registration successful! Please login.";
            if (!headers_sent()) {
                header("Location: /login");
                exit;
            } else {
                echo "<script>window.location.href = '/login';</script>";
                exit;
            }

        } catch (Exception $e) {
            $errors[] = $e->getMessage();
            // Keep the form values for better UX
            $email = $_POST['email'] ?? '';
            $username = $_POST['username'] ?? '';
            $phoneNumber = $_POST['phone_number'] ?? '';
            $address = $_POST['address'] ?? '';
            require(__DIR__ . '/../views/auth/register.php');
            return;
        }
    }

    public function logout()
    {
        session_unset();
        session_destroy();
        header("Location: /");
        exit;
    }

    protected function render($view, $data = []) {
        extract($data);
        require(__DIR__ . "/../views/" . $view . ".php");
    }
}
