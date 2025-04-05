<?php 
require(__DIR__ . "/../partials/header.php");
require(__DIR__ . "/../partials/toast.php");
require_once(__DIR__ . '/../../lib/Security.php');
$security = Security::getInstance();
?>

<div class="container mx-auto mt-8 flex justify-center">
    <form action="/register" method="POST" class="w-full max-w-md bg-dark-100 p-6 rounded shadow-lg border border-dark-50">
        <h2 class="text-2xl font-bold mb-6 text-center text-white">Register as Customer</h2>

        <!-- Error Messages -->
        <?php if (!empty($errors)): ?>
            <?php foreach ($errors as $error): ?>
                <?php showToast($error, 'error'); ?>
            <?php endforeach; ?>
        <?php endif; ?>

        <!-- Success Message -->
        <?php if (isset($_SESSION['success'])): ?>
            <?php showToast($_SESSION['success'], 'success'); ?>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <!-- CSRF Token -->
        <input type="hidden" name="csrf_token" value="<?= $security->generateCSRFToken(); ?>">

        <!-- EMAIL -->
        <div class="mb-4">
            <label class="block mb-1 font-semibold text-gray-200" for="email">Email</label>
            <input 
                type="email" 
                name="email" 
                id="email"
                class="w-full bg-dark-200 text-white border border-dark-50 rounded px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                required
                value="<?= htmlspecialchars($email ?? ''); ?>"
            >
            <p class="text-red-400 text-sm mt-1">Required</p>
        </div>
        
        <!-- USERNAME -->
        <div class="mb-4">
            <label class="block mb-1 font-semibold text-gray-200" for="username">Username</label>
            <input 
                type="text" 
                name="username" 
                id="username"
                class="w-full bg-dark-200 text-white border border-dark-50 rounded px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                required
                value="<?= htmlspecialchars($username ?? ''); ?>"
            >
            <p class="text-red-400 text-sm mt-1">Required</p>
        </div>

        <!-- PASSWORD -->
        <div class="mb-4">
            <label class="block mb-1 font-semibold text-gray-200" for="password">Password</label>
            <input 
                type="password" 
                name="password" 
                id="password"
                class="w-full bg-dark-200 text-white border border-dark-50 rounded px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                required
            >
            <p class="text-red-400 text-sm mt-1">Required</p>
            <p class="text-gray-400 text-sm mt-1">Must be at least 8 characters long and contain uppercase, lowercase, number, and special character</p>
        </div>

        <!-- CONFIRM PASSWORD -->
        <div class="mb-4">
            <label class="block mb-1 font-semibold text-gray-200" for="confirm_password">Confirm Password</label>
            <input 
                type="password" 
                name="confirm_password" 
                id="confirm_password"
                class="w-full bg-dark-200 text-white border border-dark-50 rounded px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                required
            >
            <p class="text-red-400 text-sm mt-1">Required</p>
        </div>

        <!-- Phone Number -->
        <div class="mb-4">
            <label class="block mb-1 font-semibold text-gray-200" for="phone_number">Phone Number</label>
            <input 
                type="text" 
                name="phone_number" 
                id="phone_number" 
                class="w-full bg-dark-200 text-white border border-dark-50 rounded px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                value="<?= htmlspecialchars($phoneNumber ?? ''); ?>"
            >
            <p class="text-gray-400 text-sm mt-1">Optional</p>
        </div>

        <!-- Address -->
        <div class="mb-4">
            <label class="block mb-1 font-semibold text-gray-200" for="address">Address</label>
            <input 
                type="text" 
                name="address" 
                id="address" 
                class="w-full bg-dark-200 text-white border border-dark-50 rounded px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                value="<?= htmlspecialchars($address ?? ''); ?>"
            >
            <p class="text-gray-400 text-sm mt-1">Optional</p>
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition duration-200">
            Register
        </button>

        <p class="mt-4 text-center text-gray-300">
            Already have an account? 
            <a href="/login" class="text-blue-400 hover:text-blue-300">Login here</a>
        </p>
    </form>
</div>

<?php require(__DIR__ . "/../partials/footer.php"); ?>
