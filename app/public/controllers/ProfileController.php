<?php

require_once(__DIR__ . '/../models/UserModel.php');
require_once(__DIR__ . '/../models/HairdresserModel.php');
require_once(__DIR__ . '/../lib/Auth.php'); // your helper file

class ProfileController
{
    private $userModel;
    private $hairdresserModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->hairdresserModel = new HairdresserModel();
    }

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

        // 3) If POST, handle updates
        $successMsg = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Gather form inputs (apply to either user or hairdresser)
            $newEmail       = $_POST['email']          ?? $profileData['email']        ?? '';
            $newUsername    = $_POST['username']       ?? $profileData['username']     ?? '';
            $newPassword    = $_POST['new_password']   ?? '';
            $newPhone       = $_POST['phone_number']   ?? $profileData['phone_number'] ?? '';
            $newAddress     = $_POST['address']        ?? $profileData['address']      ?? '';
            $newPicture     = $_POST['profile_picture']?? $profileData['profile_picture'] ?? '';

            // If there's a "specialization" field in the form:
            // only honor it if not hairdresser
            if (isset($_POST['specialization']) && $role !== 'hairdresser') {
                $newSpecialization = $_POST['specialization'];
            } else {
                // Keep old specialization for hairdressers or no specialization
                $newSpecialization = $profileData['specialization'] ?? null;
            }

            // Only update password if user typed something
            if (!empty($newPassword)) {
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            } else {
                // Keep old password
                $hashedPassword = $profileData['password'] ?? '';
            }

            // Build updated data array
            $data = [
                'email'           => $newEmail,
                'name'            => $newUsername, // For hairdressers it's 'name', for user it's 'username'
                'username'        => $newUsername, // For user models
                'password'        => $hashedPassword,
                'phone_number'    => $newPhone,
                'address'         => $newAddress,
                'profile_picture' => $newPicture,
                'specialization'  => $newSpecialization
            ];

            // If the user is an admin or normal user -> update in UserModel
            // If hairdresser -> update in HairdresserModel
            if ($role === 'admin' || $role === 'user') {
                // Merge in is_admin if admin. 
                // If $role==='admin', keep the is_admin from $profileData.
                // If $role==='user', set is_admin=0 or keep old if you prefer not to override.
                $isAdminValue = ($role === 'admin' ? ($profileData['is_admin'] ?? 1) : 0);

                // If your UserModel->update() requires is_admin not be null:
                $data['is_admin'] = $isAdminValue;

                // For user models, the key for 'name' is actually 'username' in DB
                // so rename or ensure your model uses 'username'
                $this->userModel->update($profileData['id'], $data);
                // Refresh profile data
                $profileData = $this->userModel->getById($profileData['id']);
            } else {
                // hairdresser
                // In hairdressers table, typically 'name' is the hairdresser name
                // so rename 'username' => 'name' if needed
                $data['name'] = $newUsername;
                $this->hairdresserModel->update($profileData['id'], $data);
                // Refresh profile data
                $profileData = $this->hairdresserModel->getById($profileData['id']);
            }

            $successMsg = "Profile updated successfully!";
        }

        // 4) Load the profile view with the $profileData, $role, and $successMsg
        require(__DIR__ . '/../views/profile/profile.php');
    }
}