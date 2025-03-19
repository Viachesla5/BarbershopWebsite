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

            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            $validator->validateEmail($email);
            $validator->validateRequired('password', $password, 'Password');

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
            $phoneNumber = $security->sanitizeInput($_POST['phone_number'] ?? '');
            $address = $security->sanitizeInput($_POST['address'] ?? '');

            // Validate required fields
            if (empty($email) || empty($username) || empty($password)) {
                throw new Exception('Email, username, and password are required.');
            }

            // Validate email format
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new Exception('Invalid email format.');
            }

            // Check email uniqueness in both users and hairdressers tables
            $stmt = parent::$pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->fetchColumn() > 0) {
                throw new Exception('Email is already registered.');
            }

            $stmt = parent::$pdo->prepare("SELECT COUNT(*) FROM hairdressers WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->fetchColumn() > 0) {
                throw new Exception('Email is already registered.');
            }

            // Validate username length
            if (strlen($username) < 3 || strlen($username) > 50) {
                throw new Exception('Username must be between 3 and 50 characters.');
            }

            // Validate password strength
            if (!$security->validatePasswordStrength($password)) {
                throw new Exception('Password must be at least 8 characters long and contain uppercase, lowercase, number, and special character.');
            }

            // Validate phone number format if provided
            if (!empty($phoneNumber) && !preg_match('/^\+?[0-9\s-()]{8,20}$/', $phoneNumber)) {
                throw new Exception('Invalid phone number format.');
            }

            // Hash password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert user into database
            $stmt = parent::$pdo->prepare("
                INSERT INTO users (email, username, password, phone_number, address, created_at)
                VALUES (?, ?, ?, ?, ?, NOW())
            ");

            $stmt->execute([$email, $username, $hashedPassword, $phoneNumber ?: null, $address ?: null]);

            // Set success message and redirect
            $_SESSION['success_message'] = 'Registration successful! Please log in.';
            header('Location: /login');
            exit;

        } catch (Exception $e) {
            $errors[] = $e->getMessage();
            $this->render('auth/register', [
                'errors' => $errors,
                'email' => $email ?? '',
                'username' => $username ?? '',
                'phoneNumber' => $phoneNumber ?? '',
                'address' => $address ?? ''
            ]);
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
