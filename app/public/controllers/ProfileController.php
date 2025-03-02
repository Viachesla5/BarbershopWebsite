<?php

require_once(__DIR__ . '/../models/UserModel.php');
require_once(__DIR__ . '/../models/HairdresserModel.php');
require_once(__DIR__ . '/../lib/Auth.php'); // your helper file with requireProfileAccess()

class ProfileController
{
    private $userModel;
    private $hairdresserModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->hairdresserModel = new HairdresserModel();
    }

    /**
     * Handle viewing and editing a user's or hairdresser's profile (text fields).
     * (No changes here except ensuring no debug echos.)
     */
    public function profile()
    {
        requireProfileAccess();

        $role = null;
        $profileData = null;

        if (!empty($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1) {
            $role = 'admin';
            $userId = $_SESSION['user_id'];
            $profileData = $this->userModel->getById($userId);
        } elseif (!empty($_SESSION['hairdresser_id'])) {
            $role = 'hairdresser';
            $hdId = $_SESSION['hairdresser_id'];
            $profileData = $this->hairdresserModel->getById($hdId);
        } elseif (!empty($_SESSION['user_id'])) {
            $role = 'user';
            $userId = $_SESSION['user_id'];
            $profileData = $this->userModel->getById($userId);
        }

        $successMsg = null;
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // textual profile updates – no file uploads
            $newEmail       = filter_var($_POST['email']          ?? '', FILTER_SANITIZE_EMAIL);
            $newUsername    = filter_var($_POST['username']       ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $newPasswordRaw = filter_var($_POST['new_password']   ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $newPhone       = filter_var($_POST['phone_number']   ?? '', FILTER_SANITIZE_NUMBER_INT);
            $newAddress     = filter_var($_POST['address']        ?? '', FILTER_SANITIZE_SPECIAL_CHARS);

            if ($role === 'hairdresser') {
                $newSpecialization = $profileData['specialization'] ?? null;
                if (isset($_POST['specialization'])) {
                    $newSpecialization = filter_var($_POST['specialization'], FILTER_SANITIZE_SPECIAL_CHARS);
                }
            }

            if (!empty($newPasswordRaw)) {
                $hashedPassword = password_hash($newPasswordRaw, PASSWORD_DEFAULT);
            } else {
                $hashedPassword = $profileData['password'] ?? '';
            }

            $data = [
                'email'        => $newEmail,
                'phone_number' => $newPhone,
                'address'      => $newAddress,
                'password'     => $hashedPassword,
            ];

            if ($role === 'hairdresser') {
                $data['name'] = $newUsername;
                $data['specialization'] = $newSpecialization ?? '';
            } else {
                $data['username'] = $newUsername;
            }

            if ($role === 'admin' || $role === 'user') {
                $isAdminVal = ($role === 'admin') ? ($profileData['is_admin'] ?? 1) : 0;
                $data['is_admin'] = $isAdminVal;
            }

            if (empty($errors)) {
                if ($role === 'hairdresser') {
                    $this->hairdresserModel->update($profileData['id'], $data);
                    $profileData = $this->hairdresserModel->getById($profileData['id']);
                } else {
                    $this->userModel->update($profileData['id'], $data);
                    $profileData = $this->userModel->getById($profileData['id']);
                }
                $successMsg = "Profile updated successfully!";
            }
        }

        require(__DIR__ . '/../views/profile/profile.php');
    }

    /**
     * NEW: Handle AJAX-based file upload for real profile picture
     * Route: POST /profile/uploadPicture
     */
    public function uploadPicture()
    {
        requireUser();

        // Clear any output buffer
        while (ob_get_level()) {
            ob_end_clean();
        }
        header('Content-Type: application/json; charset=UTF-8');

        if (!isset($_FILES['profilePic']) || $_FILES['profilePic']['error'] !== UPLOAD_ERR_OK) {
            echo json_encode(['success' => false, 'message' => 'No file or upload error.']);
            exit;
        }

        $file = $_FILES['profilePic'];
        $allowedTypes = ['image/jpeg','image/png','image/gif'];
        if (!in_array($file['type'], $allowedTypes)) {
            echo json_encode(['success' => false, 'message' => 'Invalid file type (only JPG, PNG, GIF).']);
            exit;
        }

        // Move file to /public/uploads
        $uploadDir = __DIR__ . '/../../public/uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0775, true);
        }
        $fileName = time() . '_' . basename($file['name']);
        $targetPath = $uploadDir . $fileName;

        if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
            echo json_encode(['success' => false, 'message' => 'Failed to move uploaded file.']);
            exit;
        }

        $filePathInDB = '/uploads/' . $fileName;

        // Check if user is hairdresser or normal user
        if (!empty($_SESSION['hairdresser_id'])) {
            // hairdresser
            $hdId = $_SESSION['hairdresser_id'];
            $this->hairdresserModel->updateProfilePicture($hdId, $filePathInDB); 
        } else {
            // user or admin
            $userId = $_SESSION['user_id'];
            $this->userModel->updateProfilePicture($userId, $filePathInDB); 
        }

        echo json_encode([
            'success' => true,
            'message' => 'File uploaded successfully!',
            'filePath' => $filePathInDB
        ]);
        exit;
    }

    public function showProfile($id)
    {
        $user = $this->userModel->getById($id);
        require(__DIR__ . '/../views/profile/show.php');
    }
}
