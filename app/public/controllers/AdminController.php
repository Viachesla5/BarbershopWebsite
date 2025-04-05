<?php
require_once(__DIR__ . '/../lib/Validator.php');
require_once(__DIR__ . '/../models/UserModel.php');
require_once(__DIR__ . '/../models/HairdresserModel.php');
require_once(__DIR__ . '/../models/AppointmentModel.php');
require_once(__DIR__ . '/../lib/Security.php');

class AdminController
{
    private $userModel;
    private $hairdresserModel;
    private $appointmentModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->hairdresserModel = new HairdresserModel();
        $this->appointmentModel = new AppointmentModel();
    }

    private function isAdmin()
    {
        return isset($_SESSION['user_id']) && isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === 1;
    }

    /************************************************************
     * ADMIN DASHBOARD
     ************************************************************/
    public function dashboard()
    {
        requireAdmin();

        // Get total counts
        $total_users = count($this->userModel->getAll());
        $total_hairdressers = count($this->hairdresserModel->getAll());
        $total_appointments = count($this->appointmentModel->getAll());

        // Get recvent activities (last 10 appointments)
        $recent_appointments = $this->appointmentModel->getRecent(10);
        $recent_activities = [];

        foreach ($recent_appointments as $apt) {
            $user = $this->userModel->getById($apt['user_id']);
            $hairdresser = $this->hairdresserModel->getById($apt['hairdresser_id']);

            // Format the appointment date and time
            $date = new DateTime($apt['appointment_date'] . ' ' . $apt['appointment_time']);
            $formattedDate = $date->format('Y-m-d H:i:s');

            $recent_activities[] = [
                'date' => $formattedDate,
                'description' => "Appointment scheduled with " . ($hairdresser['name'] ?? 'Unknown Hairdresser'),
                'user' => $user['username'] ?? 'Unknown User',
                'status' => $apt['status']
            ];
        }

        require(__DIR__ . '/../views/admin/dashboard.php');
    }

    /************************************************************
     * USERS
     ************************************************************/
    public function listUsers()
    {
        // error_log("banana", 3, "logs/debug.log");

        requireAdmin();
        $users = $this->userModel->getAll();
        require(__DIR__ . '/../views/admin/users_list.php');
    }

    public function showUser($id)
    {
        requireAdmin();
    
        // Fetch user details by ID
        $user = $this->userModel->getById($id);
    
        // Load a view to display the user details
        require(__DIR__ . '/../views/admin/user_show.php');
    }

    public function createUser()
    {
        requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $security = Security::getInstance();
                
                // Validate CSRF token
                $security->validateCSRFToken($_POST['csrf_token'] ?? '');
                
                // Check rate limit
                $security->checkRateLimit('create_user', $_SERVER['REMOTE_ADDR']);

                // Sanitize inputs
                $email = $security->sanitizeInput($_POST['email'] ?? '');
                $username = $security->sanitizeInput($_POST['username'] ?? '');
                $password = $_POST['password'] ?? ''; // Don't sanitize password
                $confirmPassword = $_POST['confirm_password'] ?? '';
                $phoneNumber = $security->sanitizeInput($_POST['phone_number'] ?? '');
                $address = $security->sanitizeInput($_POST['address'] ?? '');
                $isAdminInput = isset($_POST['is_admin']) ? 1 : 0;

                $validator = new Validator();

                // Validate required fields
                if (empty($email) || empty($username) || empty($password) || empty($confirmPassword)) {
                    throw new Exception('All fields are required.');
                }

                // Validate password match
                if ($password !== $confirmPassword) {
                    throw new Exception('Passwords do not match.');
                }

                // Check if email already exists in users table
                if ($this->userModel->getByEmail($email)) {
                    throw new Exception('Email address is already registered');
                }

                // Check if email already exists in hairdressers table
                if ($this->hairdresserModel->getByEmail($email)) {
                    throw new Exception('Email address is already registered');
                }

                // Validate email format
                $validator->validateEmail($email);

                // Username must be at least 3 chars
                $validator->validateUsername($username, 3);

                // Validate password strength
                $security->validatePasswordStrength($password);

                // Phone number is optional, but if provided, must contain only digits
                if (!empty($phoneNumber)) {
                    $validator->validatePhoneNumber($phoneNumber);
                }

                // Address is optional, but let's limit to 200 chars
                if (!empty($address)) {
                    $validator->validateMaxLength('address', $address, 200, 'Address');
                }

                // If we get here, all validations passed
                $data = [
                    'email' => $email,
                    'username' => $username,
                    'password' => password_hash($password, PASSWORD_DEFAULT),
                    'phone_number' => $phoneNumber ?: null,
                    'address' => $address ?: null,
                    'profile_picture' => null,
                    'is_admin' => $isAdminInput
                ];

                $this->userModel->create($data);
                header("Location: /admin/users");
                exit;

            } catch (Exception $e) {
                $errors = [$e->getMessage()];
                require(__DIR__ . '/../views/admin/user_create_form.php');
                return;
            }
        } else {
            require(__DIR__ . '/../views/admin/user_create_form.php');
        }
    }

    public function editUser($id)
    {
        requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = $this->userModel->getById($id);

            $data = [
                'email' => $_POST['email'],
                'username' => $_POST['username'],
                'password' => !empty($_POST['password']) 
                            ? password_hash($_POST['password'], PASSWORD_DEFAULT) 
                            : $user['password'],
                'phone_number' => $_POST['phone_number'] ?? $user['phone_number'],
                'address' => $_POST['address'] ?? $user['address'],
                'profile_picture' => $user['profile_picture'],
                'is_admin' => !empty($_POST['is_admin']) ? 1 : 0
            ];

            $this->userModel->update($id, $data);
            
            // Fetch updated user data
            $user = $this->userModel->getById($id);
            $success = "User updated successfully!";
            require(__DIR__ . '/../views/admin/user_edit_form.php');
            return;
        } else {
            $user = $this->userModel->getById($id);
            require(__DIR__ . '/../views/admin/user_edit_form.php');
        }
    }

    public function uploadUserPicture($id)
    {
        requireAdmin();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            return;
        }

        if (!isset($_FILES['profilePic'])) {
            echo json_encode(['success' => false, 'message' => 'No file uploaded']);
            return;
        }

        $file = $_FILES['profilePic'];
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $maxSize = 5 * 1024 * 1024; // 5MB

        // Validate file type and size
        if (!in_array($file['type'], $allowedTypes)) {
            echo json_encode(['success' => false, 'message' => 'Invalid file type. Only JPG, PNG, and GIF are allowed.']);
            return;
        }

        if ($file['size'] > $maxSize) {
            echo json_encode(['success' => false, 'message' => 'File is too large. Maximum size is 5MB.']);
            return;
        }

        // Create uploads directory if it doesn't exist
        $uploadDir = __DIR__ . '/../uploads/profile_pictures/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Get current user data to check for existing profile picture
        $user = $this->userModel->getById($id);
        
        // Delete old profile picture if it exists
        if (!empty($user['profile_picture'])) {
            $oldFilePath = __DIR__ . '/..' . $user['profile_picture'];
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }
        }

        // Generate unique filename
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid('profile_') . '.' . $extension;
        $filepath = $uploadDir . $filename;

        // Move uploaded file
        if (move_uploaded_file($file['tmp_name'], $filepath)) {
            // Update user's profile picture in database
            $user['profile_picture'] = '/uploads/profile_pictures/' . $filename;
            $this->userModel->update($id, $user);

            echo json_encode([
                'success' => true,
                'message' => 'Profile picture uploaded successfully',
                'filePath' => $user['profile_picture']
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to upload file']);
        }
    }

    public function deleteUser($id)
    {
        requireAdmin();
        
        // Get user data before deletion to check for profile picture
        $user = $this->userModel->getById($id);
        
        // Delete profile picture if it exists
        if (!empty($user['profile_picture'])) {
            $picturePath = __DIR__ . '/..' . $user['profile_picture'];
            if (file_exists($picturePath)) {
                unlink($picturePath);
            }
        }
        
        // Delete user from database
        $this->userModel->delete(filter_var($id, FILTER_VALIDATE_INT));
        
        header("Location: /admin/users");
        exit;
    }

    /************************************************************
     * HAIRDRESSERS
     ************************************************************/
    public function listHairdressers()
    {
        requireAdmin();
        $hairdressers = $this->hairdresserModel->getAll();
        require(__DIR__ . '/../views/admin/hairdressers_list.php');
    }

    public function showHairdresser($id)
    {
        requireAdmin();
        // Fetch hairdresser details
        $hairdresser = $this->hairdresserModel->getById($id);

        // If hairdresser not found, redirect or show an error
        if (!$hairdresser) {
            header("Location: /admin/hairdressers");
            exit;
        }

        require(__DIR__ . '/../views/admin/hairdresser_detail.php');
    }

    public function createHairdresser()
    {
        requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $security = Security::getInstance();
                
                // Validate CSRF token
                $security->validateCSRFToken($_POST['csrf_token'] ?? '');
                
                // Check rate limit
                $security->checkRateLimit('create_hairdresser', $_SERVER['REMOTE_ADDR']);

                // Sanitize inputs
                $email = $security->sanitizeInput($_POST['email'] ?? '');
                $name = $security->sanitizeInput($_POST['name'] ?? '');
                $password = $_POST['password'] ?? '';
                $confirmPassword = $_POST['confirm_password'] ?? '';
                $specialization = $security->sanitizeInput($_POST['specialization'] ?? '');
                $phoneNumber = $security->sanitizeInput($_POST['phone_number'] ?? '');
                $address = $security->sanitizeInput($_POST['address'] ?? '');

                // Validate required fields
                if (empty($email) || empty($name) || empty($password) || empty($confirmPassword) || empty($specialization)) {
                    throw new Exception('All fields are required.');
                }

                // Validate password match
                if ($password !== $confirmPassword) {
                    throw new Exception('Passwords do not match.');
                }

                // Validate email format
                $validator = new Validator();
                $validator->validateEmail($email);

                // Name must be at least 2 chars
                if (strlen($name) < 2) {
                    throw new Exception('Name must be at least 2 characters long');
                }

                // Validate password strength
                $security->validatePasswordStrength($password);

                // Specialization is required and must be at least 3 chars
                if (strlen($specialization) < 3) {
                    throw new Exception('Specialization must be at least 3 characters long');
                }

                // Phone number is optional, but if provided, must contain only digits
                if (!empty($phoneNumber)) {
                    $validator->validatePhoneNumber($phoneNumber);
                }

                // Address is optional, but let's limit to 200 chars
                if (!empty($address)) {
                    $validator->validateMaxLength('address', $address, 200, 'Address');
                }

                // Check if email already exists in hairdressers table
                if ($this->hairdresserModel->getByEmail($email)) {
                    throw new Exception('Email address is already registered');
                }

                // Check if email already exists in users table
                if ($this->userModel->getByEmail($email)) {
                    throw new Exception('Email address is already registered');
                }

                // If we get here, all validations passed
                $data = [
                    'email' => $email,
                    'name' => $name,
                    'password' => password_hash($password, PASSWORD_DEFAULT),
                    'specialization' => $specialization,
                    'phone_number' => $phoneNumber ?: null,
                    'address' => $address ?: null,
                    'profile_picture' => null
                ];

                $this->hairdresserModel->create($data);
                header("Location: /admin/hairdressers");
                exit;

            } catch (Exception $e) {
                $errors = [$e->getMessage()];
                require(__DIR__ . '/../views/admin/hairdresser_create_form.php');
                return;
            }
        } else {
            require(__DIR__ . '/../views/admin/hairdresser_create_form.php');
        }
    }

    public function editHairdresser($id)
    {
        requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $hairdresser = $this->hairdresserModel->getById($id);

            $data = [
                'email' => $_POST['email'],
                'name' => $_POST['name'],
                'password' => !empty($_POST['password']) 
                            ? password_hash($_POST['password'], PASSWORD_DEFAULT) 
                            : $hairdresser['password'],
                'phone_number' => $_POST['phone_number'] ?? $hairdresser['phone_number'],
                'address' => $_POST['address'] ?? $hairdresser['address'],
                'specialization' => $_POST['specialization'] ?? $hairdresser['specialization'],
                'profile_picture' => $hairdresser['profile_picture'] // Keep existing profile picture
            ];

            $this->hairdresserModel->update($id, $data);
            
            // Fetch updated hairdresser data
            $hairdresser = $this->hairdresserModel->getById($id);
            $success = "Hairdresser updated successfully!";
            require(__DIR__ . '/../views/admin/hairdresser_edit_form.php');
            return;
        } else {
            $hairdresser = $this->hairdresserModel->getById($id);
            require(__DIR__ . '/../views/admin/hairdresser_edit_form.php');
        }
    }

    public function uploadHairdresserPicture($id)
    {
        requireAdmin();

        // Check if it's a POST request
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
            return;
        }

        if (!isset($_FILES['profilePic']) || $_FILES['profilePic']['error'] !== UPLOAD_ERR_OK) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'No file uploaded or upload error']);
            return;
        }

        $file = $_FILES['profilePic'];
        
        // Validate file type
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($file['type'], $allowedTypes)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Invalid file type. Only JPG, PNG and GIF are allowed.']);
            return;
        }

        // Validate file size (5MB max)
        $maxSize = 5 * 1024 * 1024; // 5MB in bytes
        if ($file['size'] > $maxSize) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'File too large. Maximum size is 5MB.']);
            return;
        }

        // Create uploads directory if it doesn't exist
        $uploadDir = __DIR__ . '/../uploads/hairdressers';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Get current hairdresser data to check for existing profile picture
        $hairdresser = $this->hairdresserModel->getById($id);
        
        // Delete old profile picture if it exists
        if (!empty($hairdresser['profile_picture'])) {
            $oldFilePath = __DIR__ . '/..' . $hairdresser['profile_picture'];
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }
        }

        // Generate unique filename
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid('hairdresser_' . $id . '_') . '.' . $extension;
        $filepath = $uploadDir . '/' . $filename;

        // Move uploaded file
        if (move_uploaded_file($file['tmp_name'], $filepath)) {
            // Update hairdresser's profile picture in database
            $hairdresser['profile_picture'] = '/uploads/hairdressers/' . $filename;
            $this->hairdresserModel->update($id, $hairdresser);

            echo json_encode([
                'success' => true,
                'filePath' => $hairdresser['profile_picture']
            ]);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Failed to upload file']);
        }
    }

    public function deleteHairdresser($id)
    {
        requireAdmin();
        
        // Get hairdresser data before deletion to check for profile picture
        $hairdresser = $this->hairdresserModel->getById($id);
        
        // Delete profile picture if it exists
        if (!empty($hairdresser['profile_picture'])) {
            $picturePath = __DIR__ . '/..' . $hairdresser['profile_picture'];
            if (file_exists($picturePath)) {
                unlink($picturePath);
            }
        }
        
        // Delete hairdresser from database
        $this->hairdresserModel->delete(filter_var($id, FILTER_VALIDATE_INT));
        header("Location: /admin/hairdressers");
        exit;
    }

    /************************************************************
     * APPOINTMENTS
     ************************************************************/
    public function listAppointments()
    {
        requireAdmin();
        $appointments = $this->appointmentModel->getAllWithNames();
        require(__DIR__ . '/../views/admin/appointments_list.php');
    }

    public function changeAppointmentStatus($id)
    {
        requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newStatus = $_POST['status']; // 'completed', 'canceled', or 'upcoming'
            $aptData   = $this->appointmentModel->getById($id);
            if ($aptData) {
                $aptData['status'] = $newStatus;
                $this->appointmentModel->update($id, $aptData);
            }
            header("Location: /admin/appointments");
            exit;
        }
    }

    public function editAppointment($id)
    {
        requireAdmin();

        // Get appointment data
        $appointment = $this->appointmentModel->getById($id);
        error_log("Appointment data: " . print_r($appointment, true));
        
        if (!$appointment) {
            $_SESSION['error'] = "Appointment not found.";
            header("Location: /admin/appointments");
            exit;
        }

        // Get all users and hairdressers for dropdowns
        $users = $this->userModel->getAll();
        error_log("Users data: " . print_r($users, true));
        
        $hairdressers = $this->hairdresserModel->getAll();
        error_log("Hairdressers data: " . print_r($hairdressers, true));

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $security = Security::getInstance();
                
                // Validate CSRF token
                $security->validateCSRFToken($_POST['csrf_token'] ?? '');
                
                // Check rate limit
                $security->checkRateLimit('edit_appointment', $_SERVER['REMOTE_ADDR']);

                // Sanitize inputs
                $userId = $security->sanitizeInput($_POST['user_id'] ?? '');
                $hairdresserId = $security->sanitizeInput($_POST['hairdresser_id'] ?? '');
                $appointmentDate = $security->sanitizeInput($_POST['appointment_date'] ?? '');
                $appointmentTime = $security->sanitizeInput($_POST['appointment_time'] ?? '');
                $status = $security->sanitizeInput($_POST['status'] ?? '');

                // Validate required fields
                if (empty($userId) || empty($hairdresserId) || empty($appointmentDate) || empty($appointmentTime) || empty($status)) {
                    throw new Exception("All fields are required.");
                }

                // Validate date and time
                $appointmentDateTime = strtotime($appointmentDate . ' ' . $appointmentTime);
                if ($appointmentDateTime < time()) {
                    throw new Exception("Appointment date and time cannot be in the past.");
                }

                // Check for appointment conflicts
                $conflict = $this->appointmentModel->findByHairdresserDateTime($hairdresserId, $appointmentDate, $appointmentTime);
                if ($conflict && $conflict['id'] != $id) {
                    throw new Exception("This time slot is already booked for the selected hairdresser.");
                }

                // Update appointment
                $this->appointmentModel->update($id, [
                    'user_id' => $userId,
                    'hairdresser_id' => $hairdresserId,
                    'appointment_date' => $appointmentDate,
                    'appointment_time' => $appointmentTime,
                    'status' => $status
                ]);

                $_SESSION['success'] = "Appointment updated successfully.";
                header("Location: /admin/appointments");
                exit;

            } catch (Exception $e) {
                $_SESSION['error'] = $e->getMessage();
            }
        }

        // Load the edit form view
        require(__DIR__ . '/../views/admin/appointments/edit.php');
    }

    public function deleteAppointment($id)
    {
        requireAdmin();
        
        try {
            // Get appointment data before deletion
            $appointment = $this->appointmentModel->getById($id);
            
            if (!$appointment) {
                $_SESSION['error'] = "Appointment not found.";
                header("Location: /admin/appointments");
                exit;
            }

            // Delete the appointment
            $this->appointmentModel->delete($id);
            
            $_SESSION['success'] = "Appointment deleted successfully.";
        } catch (Exception $e) {
            $_SESSION['error'] = "Failed to delete appointment: " . $e->getMessage();
        }
        
        header("Location: /admin/appointments");
        exit;
    }
}