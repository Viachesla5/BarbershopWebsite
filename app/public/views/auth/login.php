<?php 
require(__DIR__ . "/../partials/header.php");
require(__DIR__ . "/../partials/toast.php");
?>

<div class="container mx-auto mt-8 flex justify-center">
    <form action="/login" method="POST" class="w-full max-w-md bg-dark-100 p-6 rounded shadow-lg border border-dark-50">
        <h2 class="text-2xl font-bold mb-6 text-center text-white">Login</h2>

        <?php if (!empty($errors)): ?>
            <?php foreach ($errors as $err): ?>
                <?php showToast($err, 'error'); ?>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
            <?php showToast($_SESSION['success'], 'success'); ?>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <div class="mb-4">
            <label class="block mb-1 font-semibold text-gray-200" for="email">Email</label>
            <input 
                type="email"
                name="email"
                id="email"
                class="w-full bg-dark-200 text-white border border-dark-50 rounded px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                required
            >
        </div>

        <div class="mb-6">
            <label class="block mb-1 font-semibold text-gray-200" for="password">Password</label>
            <input 
                type="password"
                name="password"
                id="password"
                class="w-full bg-dark-200 text-white border border-dark-50 rounded px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                required
            >
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition duration-200">
            Login
        </button>

        <p class="mt-4 text-center text-gray-300">
            Don't have an account? 
            <a href="/register" class="text-blue-400 hover:text-blue-300">Register here</a>
        </p>
    </form>
</div>

<?php require(__DIR__ . "/../partials/footer.php"); ?>