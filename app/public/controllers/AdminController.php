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

    /************************************************************
     * ADMIN DASHBOARD
     ************************************************************/
    public function dashboard()
    {
        requireAdmin();
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
                'profile_picture' => $_POST['profile_picture'] ?? $user['profile_picture'],
                'is_admin' => !empty($_POST['is_admin']) ? 1 : 0
            ];

            $this->userModel->update($id, $data);

            header("Location: /admin/users");
            exit;
        } else {
            $user = $this->userModel->getById($id);
            require(__DIR__ . '/../views/admin/user_edit_form.php');
        }
    }

    public function deleteUser($id)
    {
        requireAdmin();
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
            // Fetch existing data
            $hd = $this->hairdresserModel->getById($id);

            // Gather form inputs and fallback to existing values if empty
            $data = [
                'email'          => filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) ?? $hd['email'],
                'name'           => filter_var($_POST['name'], FILTER_SANITIZE_SPECIAL_CHARS) ?? $hd['name'],
                'specialization' => filter_var($_POST['specialization'], FILTER_SANITIZE_SPECIAL_CHARS) ?? $hd['specialization'],
                'phone_number'   => filter_var($_POST['phone_number'], FILTER_SANITIZE_NUMBER_INT) ?? $hd['phone_number'],
                'address'        => filter_var($_POST['address'], FILTER_SANITIZE_SPECIAL_CHARS) ?? $hd['address'],
                'profile_picture'=> $_POST['profile_picture'] ?? $hd['profile_picture'],
                'password'       => !empty(filter_var($_POST['password'], FILTER_SANITIZE_SPECIAL_CHARS)) 
                                        ? password_hash(filter_var($_POST['password'], FILTER_SANITIZE_SPECIAL_CHARS), PASSWORD_DEFAULT) 
                                        : $hd['password'] // Retain existing password if none provided
            ];

            // Update hairdresser in the database
            $this->hairdresserModel->update($id, $data);

            // Redirect back to the hairdresser list
            header("Location: /admin/hairdressers");
            exit;
        } else {
            // GET request - load the form with existing data
            $hairdresser = $this->hairdresserModel->getById($id);
            require(__DIR__ . '/../views/admin/hairdresser_edit_form.php');
        }
    }


    public function deleteHairdresser($id)
    {
        requireAdmin();
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