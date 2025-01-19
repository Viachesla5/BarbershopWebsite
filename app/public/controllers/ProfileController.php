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
     * Handle viewing and editing a user's or hairdresser's profile.
     */
    public function profile()
    {
        // 1) Ensure that at least user/hairdresser/admin is logged in
        requireProfileAccess();

        // 2) Determine which role is logged in and fetch the corresponding data
        $role = null;
        $profileData = null;

        if (!empty($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1) {
            // Admin is basically a user record with is_admin=1
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

        // 3) If POST, handle profile updates
        $successMsg = null;
        $errors = []; // optional array to store error messages

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Gather form inputs (apply to either user or hairdresser)
            $newEmail       = filter_var($_POST['email']          ?? '', FILTER_SANITIZE_EMAIL);
            $newUsername    = filter_var($_POST['username']       ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $newPasswordRaw = filter_var($_POST['new_password']   ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $newPhone       = filter_var($_POST['phone_number']   ?? '', FILTER_SANITIZE_NUMBER_INT);
            $newAddress     = filter_var($_POST['address']        ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            
            // This is the user-provided profile picture URL or file path
            $newPicture     = trim($_POST['profile_picture']      ?? '');
            // Validate the URL if it's not empty (optional)
            if (!empty($newPicture)) {
                $validatedPicture = filter_var($newPicture, FILTER_VALIDATE_URL);
                if ($validatedPicture === false) {
                   
                }
            }

            // If there's a "specialization" field for hairdressers, posted or not
            $newSpecialization = $profileData['specialization'] ?? null; // fallback
            if (isset($_POST['specialization']) && $role === 'hairdresser') {
                $newSpecialization = filter_var($_POST['specialization'], FILTER_SANITIZE_SPECIAL_CHARS);
            }

            // Only update password if user typed something
            if (!empty($newPasswordRaw)) {
                $hashedPassword = password_hash($newPasswordRaw, PASSWORD_DEFAULT);
            } else {
                // Keep old password from DB
                $hashedPassword = $profileData['password'] ?? '';
            }

            
            $data = [
                'email'           => $newEmail,
                'phone_number'    => $newPhone,
                'address'         => $newAddress,
                'password'        => $hashedPassword,
                'profile_picture' => $newPicture
            ];

            // If user/hairdresser name field in DB is "name" for hairdressers, "username" for normal users:
            if ($role === 'hairdresser') {
                $data['name'] = $newUsername;           // The hairdresser table might have a 'name' column
                $data['specialization'] = $newSpecialization;
            } else {
                $data['username'] = $newUsername;       // The users table might have 'username'
            }

            // For admin or normal user:
            // Possibly keep is_admin from the old data if admin
            if ($role === 'admin' || $role === 'user') {
                // If your user table has an 'is_admin' column, set it to old value or 0:
                $isAdminVal = ($role === 'admin') ? ($profileData['is_admin'] ?? 1) : 0;
                $data['is_admin'] = $isAdminVal;
            }

            // If no errors found, proceed with update
            if (empty($errors)) {
                // Call the correct model depending on role
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

        // 4) Finally, load the profile view with $profileData, $role, and potential $successMsg or $errors
        require(__DIR__ . '/../views/profile/profile.php');
    }
}