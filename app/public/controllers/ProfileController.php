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
            // Handle text fields
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
        requireProfileAccess();

        header('Content-Type: application/json; charset=UTF-8');

        if (!isset($_FILES['profilePic']) || $_FILES['profilePic']['error'] !== UPLOAD_ERR_OK) {
            echo json_encode(['success' => false, 'message' => 'No file or upload error.']);
            exit;
        }

        $file = $_FILES['profilePic'];
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $maxSize = 5 * 1024 * 1024; // 5MB

        if (!in_array($file['type'], $allowedTypes)) {
            echo json_encode(['success' => false, 'message' => 'Invalid file type. Only JPG, PNG, and GIF files are allowed.']);
            exit;
        }

        if ($file['size'] > $maxSize) {
            echo json_encode(['success' => false, 'message' => 'File is too large. Maximum size is 5MB.']);
            exit;
        }

        $uploadDir = __DIR__ . '/../uploads/profile_pictures/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $fileName = uniqid() . '.' . $fileExtension;
        $targetPath = $uploadDir . $fileName;
        $filePathInDB = '/uploads/profile_pictures/' . $fileName;

        if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
            echo json_encode(['success' => false, 'message' => 'Failed to move uploaded file.']);
            exit;
        }

        // Get current user's data to delete old picture
        $currentUser = null;
        if (!empty($_SESSION['hairdresser_id'])) {
            $currentUser = $this->hairdresserModel->getById($_SESSION['hairdresser_id']);
            if (!empty($currentUser['profile_picture'])) {
                $oldPicturePath = __DIR__ . '/..' . $currentUser['profile_picture'];
                if (file_exists($oldPicturePath)) {
                    unlink($oldPicturePath);
                }
            }
            $this->hairdresserModel->updateProfilePicture($_SESSION['hairdresser_id'], $filePathInDB);
        } else {
            $currentUser = $this->userModel->getById($_SESSION['user_id']);
            if (!empty($currentUser['profile_picture'])) {
                $oldPicturePath = __DIR__ . '/..' . $currentUser['profile_picture'];
                if (file_exists($oldPicturePath)) {
                    unlink($oldPicturePath);
                }
            }
            $this->userModel->updateProfilePicture($_SESSION['user_id'], $filePathInDB);
        }

        echo json_encode([
            'success' => true,
            'message' => 'Profile picture updated successfully!',
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
