<?php

require_once(__DIR__ . '/../models/UserModel.php');

class ProfileController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function profile()
    {
        // 1. Ensure user is logged in
        if (empty($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }

        // 2. Fetch current user data
        $userId = $_SESSION['user_id'];
        $user   = $this->userModel->getById($userId);

        // 3. If POST, handle updates
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Gather form inputs
            $newEmail      = $_POST['email'] ?? $user['email'];
            $newUsername   = $_POST['username'] ?? $user['username'];
            $newPassword   = $_POST['new_password'] ?? '';
            $newPhone      = $_POST['phone_number'] ?? $user['phone_number'];
            $newAddress    = $_POST['address'] ?? $user['address'];
            $newPicture    = $_POST['profile_picture'] ?? $user['profile_picture'];

            // Only update the password if not empty
            $passwordToSave = !empty($newPassword)
                ? password_hash($newPassword, PASSWORD_DEFAULT)
                : $user['password'];

            // Build update data
            $data = [
                'email'           => $newEmail,
                'username'        => $newUsername,
                'password'        => $passwordToSave,
                'phone_number'    => $newPhone,
                'address'         => $newAddress,
                'profile_picture' => $newPicture
            ];

            // Update in DB
            $this->userModel->update($userId, $data);

            // Fetch updated data again to display
            $user = $this->userModel->getById($userId);

            // Optionally set a success message or flash message
            $successMsg = "Profile updated successfully!";
        }

        // 4. Load the profile view (always pass $user)
        require(__DIR__ . '/../views/profile/profile.php');
    }
}
