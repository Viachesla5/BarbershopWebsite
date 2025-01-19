<?php require(__DIR__ . '/../partials/header.php'); ?>

<div class="container mx-auto mt-8">

    <h1 class="text-2xl font-bold mb-4">
        <?php if ($role === 'admin'): ?>
            Admin Profile
        <?php elseif ($role === 'hairdresser'): ?>
            Hairdresser Profile
        <?php else: ?>
            User Profile
        <?php endif; ?>
    </h1>

    <?php if (!empty($successMsg)): ?>
        <div class="mb-4 text-green-500">
            <?= htmlspecialchars($successMsg); ?>
        </div>
    <?php endif; ?>

    <!-- READ-ONLY SECTION -->
    <div class="mb-8 bg-gray-100 p-4 rounded">
        <p><strong>Email:</strong> <?= htmlspecialchars($profileData['email']); ?></p>
        <?php if ($role === 'hairdresser'): ?>
            <p><strong>Name:</strong> <?= htmlspecialchars($profileData['name'] ?? ''); ?></p>
            <p><strong>Specialization:</strong> <?= htmlspecialchars($profileData['specialization'] ?? ''); ?></p>
        <?php else: ?>
            <p><strong>Username:</strong> <?= htmlspecialchars($profileData['username'] ?? ''); ?></p>
        <?php endif; ?>

        <p><strong>Phone:</strong> <?= htmlspecialchars($profileData['phone_number'] ?? ''); ?></p>
        <p><strong>Address:</strong> <?= htmlspecialchars($profileData['address'] ?? ''); ?></p>

        <?php if (!empty($profileData['profile_picture'])): ?>
            <p><strong>Profile Picture:</strong></p>
            <img src="<?= htmlspecialchars($profileData['profile_picture']); ?>" 
                 alt="Profile Picture" 
                 class="w-32 h-32 object-cover rounded border">
        <?php endif; ?>
    </div>

    <!-- EDIT FORM -->
    <form action="/profile" method="POST" class="max-w-md bg-white p-6 rounded shadow">
        <h2 class="text-xl font-semibold mb-4">Edit Profile</h2>

        <!-- Example: Email, same for everyone -->
        <div class="mb-4">
            <label class="block mb-1 font-semibold" for="email">Email</label>
            <input 
                type="email"
                name="email"
                id="email"
                value="<?= htmlspecialchars($profileData['email']); ?>"
                class="w-full border border-gray-300 rounded px-3 py-2"
            >
        </div>

        <?php if ($role === 'hairdresser'): ?>
            <!-- Hairdresser's "name" instead of "username" -->
            <div class="mb-4">
                <label class="block mb-1 font-semibold" for="username">Name</label>
                <input
                    type="text"
                    name="username"
                    id="username"
                    value="<?= htmlspecialchars($profileData['name'] ?? ''); ?>"
                    class="w-full border border-gray-300 rounded px-3 py-2"
                >
            </div>

            <!-- SHOW the specialization as read-only or simply omit entirely -->
            <div class="mb-4 bg-gray-100 p-2 rounded">
                <label class="block mb-1 font-semibold">Specialization (Read-Only)</label>
                <p class="text-gray-600">
                    <?= htmlspecialchars($profileData['specialization'] ?? ''); ?>
                </p>
            </div>
        <?php else: ?>
            <!-- For user/admin, use "username" label -->
            <div class="mb-4">
                <label class="block mb-1 font-semibold" for="username">Username</label>
                <input
                    type="text"
                    name="username"
                    id="username"
                    value="<?= htmlspecialchars($profileData['username'] ?? ''); ?>"
                    class="w-full border border-gray-300 rounded px-3 py-2"
                >
            </div>
        <?php endif; ?>

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
            <label class="block mb-1 font-semibold" for="phone_number">Phone Number</label>
            <input
                type="text"
                name="phone_number"
                id="phone_number"
                value="<?= htmlspecialchars($profileData['phone_number'] ?? ''); ?>"
                class="w-full border border-gray-300 rounded px-3 py-2"
            >
        </div>

        <!-- ADDRESS -->
        <div class="mb-4">
            <label class="block mb-1 font-semibold" for="address">Address</label>
            <input
                type="text"
                name="address"
                id="address"
                value="<?= htmlspecialchars($profileData['address'] ?? ''); ?>"
                class="w-full border border-gray-300 rounded px-3 py-2"
            >
        </div>

        <!-- PROFILE PICTURE -->
        <div class="mb-4">
            <label class="block mb-1 font-semibold" for="profile_picture">Profile Picture</label>
            <input
                type="text"
                name="profile_picture"
                id="profile_picture"
                value="<?= htmlspecialchars($profileData['profile_picture'] ?? ''); ?>"
                class="w-full border border-gray-300 rounded px-3 py-2"
                placeholder="File path or URL"
            >
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Save Changes
        </button>
    </form>
</div>