<?php
require_once(__DIR__ . '/../lib/Validator.php');
require_once(__DIR__ . '/../models/UserModel.php');
require_once(__DIR__ . '/../models/HairdresserModel.php');
require_once(__DIR__ . '/../models/AppointmentModel.php');

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

        // Get recent activities (last 10 appointments)
        $recent_appointments = $this->appointmentModel->getRecent(10);
        $recent_activities = [];

        foreach ($recent_appointments as $apt) {
            $user = $this->userModel->getById($apt['user_id']);
            $hairdresser = $this->hairdresserModel->getById($apt['hairdresser_id']);

            $recent_activities[] = [
                'date' => $apt['created_at'],
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
            if (!empty($address)) {
                $validator->validateMaxLength('address', $address, 200, 'Address');
            }

            // Check for errors
            if ($validator->hasErrors()) {
                $errors = $validator->getErrors();
                require(__DIR__ . '/../views/auth/register.php');
                return;
            }

            $data = [
                'email' => $_POST['email'],
                'username' => $_POST['username'],
                'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
                'phone_number' => $_POST['phone_number'] ?? null,
                'address' => $_POST['address'] ?? null,
                'profile_picture' => $_POST['profile_picture'] ?? null,
                'is_admin' => !empty($_POST['is_admin']) ? 1 : 0
            ];

            $this->userModel->create($data);

            header("Location: /admin/users");
            exit;
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
        requireAdmin(); // Ensure only admins can access

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Gather form data
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $name = filter_var($_POST['name'], FILTER_SANITIZE_SPECIAL_CHARS);
            $password = password_hash(filter_var($_POST['password'], FILTER_SANITIZE_SPECIAL_CHARS), PASSWORD_DEFAULT); // Hash the password
            $specialization = filter_var($_POST['specialization'], FILTER_SANITIZE_SPECIAL_CHARS);

            // Optional fields
            $phoneNumber = filter_var($_POST['phone_number'], FILTER_SANITIZE_NUMBER_INT) ?? null;
            $address = filter_var($_POST['address'], FILTER_SANITIZE_SPECIAL_CHARS) ?? null;
            $profilePicture = $_POST['profile_picture'] ?? null;

            // Data array for creation
            $data = [
                'email' => $email,
                'name' => $name,
                'password' => $password,
                'specialization' => $specialization,
                'phone_number' => $phoneNumber,
                'address' => $address,
                'profile_picture' => $profilePicture
            ];

            // Create the hairdresser using the model
            $this->hairdresserModel->create($data);

            // Redirect back to the hairdresser list
            header("Location: /admin/hairdressers");
            exit;
        } else {
            // GET request: Show the create form
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
        $appointments = $this->appointmentModel->getAll(); // all appointments
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
}