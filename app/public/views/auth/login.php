<?php require(__DIR__ . "/../partials/header.php"); ?>

<div class="container mx-auto mt-8">
    <h1 class="text-2xl font-bold mb-4">Login</h1>

    <?php if (!empty($error)): ?>
        <div class="mb-4 text-red-500">
            <?= htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <form action="/login" method="POST" class="max-w-md bg-white p-6 rounded shadow">
        <div class="mb-4">
            <label class="block mb-1 font-semibold" for="email">Email</label>
            <input 
                type="email" 
                name="email" 
                id="email" 
                class="w-full border border-gray-300 rounded px-3 py-2"
                required
            >
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-semibold" for="password">Password</label>
            <input 
                type="password" 
                name="password" 
                id="password" 
                class="w-full border border-gray-300 rounded px-3 py-2"
                required
            >
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Log In
        </button>
    </form>

    <div class="mt-4">
        <a href="/register" class="text-blue-500 hover:underline">Don’t have an account? Register</a>
    </div>
</div>

<?php require(__DIR__ . "/../partials/footer.php"); ?>