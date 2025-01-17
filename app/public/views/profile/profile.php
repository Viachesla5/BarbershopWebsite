<?php require(__DIR__ . '/../partials/header.php'); ?>

<div class="container mx-auto mt-8">

    <h1 class="text-2xl font-bold mb-4">My Profile</h1>

    <?php if (!empty($successMsg)): ?>
        <div class="mb-4 text-green-500">
            <?= htmlspecialchars($successMsg); ?>
        </div>
    <?php endif; ?>

    <!-- Display user info (read-only section) -->
    <div class="mb-8 bg-gray-100 p-4 rounded">
        <p><strong>Email:</strong> <?= htmlspecialchars($user['email']); ?></p>
        <p><strong>Username:</strong> <?= htmlspecialchars($user['username']); ?></p>
        <p><strong>Phone:</strong> <?= htmlspecialchars($user['phone_number'] ?? ''); ?></p>
        <p><strong>Address:</strong> <?= htmlspecialchars($user['address'] ?? ''); ?></p>
        
        <?php if (!empty($user['profile_picture'])): ?>
            <p><strong>Profile Picture:</strong></p>
            <img src="<?= htmlspecialchars($user['profile_picture']); ?>" 
                 alt="Profile Picture" 
                 class="w-32 h-32 object-cover rounded border">
        <?php endif; ?>
    </div>

    <!-- Edit form (same page) -->
    <form action="/profile" method="POST" class="max-w-md bg-white p-6 rounded shadow">
        
        <h2 class="text-xl font-semibold mb-4">Edit Profile</h2>

        <!-- EMAIL -->
        <div class="mb-4">
            <label class="block mb-1 font-semibold" for="email">Email (optional)</label>
            <input 
                type="email"
                name="email"
                id="email"
                value="<?= htmlspecialchars($user['email']); ?>"
                class="w-full border border-gray-300 rounded px-3 py-2"
            >
        </div>

        <!-- USERNAME -->
        <div class="mb-4">
            <label class="block mb-1 font-semibold" for="username">Username (optional)</label>
            <input
                type="text"
                name="username"
                id="username"
                value="<?= htmlspecialchars($user['username']); ?>"
                class="w-full border border-gray-300 rounded px-3 py-2"
            >
        </div>

        <!-- NEW PASSWORD -->
        <div class="mb-4">
            <label class="block mb-1 font-semibold" for="new_password">
                New Password (leave blank to keep current)
            </label>
            <input
                type="password"
                name="new_password"
                id="new_password"
                class="w-full border border-gray-300 rounded px-3 py-2"
            >
        </div>

        <!-- PHONE NUMBER -->
        <div class="mb-4">
            <label class="block mb-1 font-semibold" for="phone_number">Phone Number (optional)</label>
            <input
                type="text"
                name="phone_number"
                id="phone_number"
                value="<?= htmlspecialchars($user['phone_number'] ?? ''); ?>"
                class="w-full border border-gray-300 rounded px-3 py-2"
            >
        </div>

        <!-- ADDRESS -->
        <div class="mb-4">
            <label class="block mb-1 font-semibold" for="address">Address (optional)</label>
            <input
                type="text"
                name="address"
                id="address"
                value="<?= htmlspecialchars($user['address'] ?? ''); ?>"
                class="w-full border border-gray-300 rounded px-3 py-2"
            >
        </div>

        <!-- PROFILE PICTURE -->
        <div class="mb-4">
            <label class="block mb-1 font-semibold" for="profile_picture">Profile Picture (optional)</label>
            <input
                type="text"
                name="profile_picture"
                id="profile_picture"
                value="<?= htmlspecialchars($user['profile_picture'] ?? ''); ?>"
                class="w-full border border-gray-300 rounded px-3 py-2"
                placeholder="File path or URL"
            >
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Save Changes
        </button>
    </form>
</div>

<?php require(__DIR__ . '/../partials/footer.php'); ?>