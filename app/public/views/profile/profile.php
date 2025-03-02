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

    <!-- SHOW SUCCESS MESSAGE IF ANY -->
    <?php if (!empty($successMsg)): ?>
        <div class="mb-4 text-green-500">
            <?= htmlspecialchars($successMsg); ?>
        </div>
    <?php endif; ?>

    <!-- SHOW ERROR MESSAGES IF ANY -->
    <?php if (!empty($errors)): ?>
        <div class="mb-4 text-red-500">
            <ul>
                <?php foreach ($errors as $err): ?>
                    <li><?= htmlspecialchars($err, ENT_QUOTES, 'UTF-8'); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- CURRENT PROFILE INFO (READ-ONLY) -->
    <div class="mb-8 bg-gray-100 p-4 rounded">
        <p><strong>Email:</strong> <?= htmlspecialchars($profileData['email'] ?? ''); ?></p>

        <?php if ($role === 'hairdresser'): ?>
            <p><strong>Name:</strong> <?= htmlspecialchars($profileData['name'] ?? ''); ?></p>
            <p><strong>Specialization:</strong> <?= htmlspecialchars($profileData['specialization'] ?? ''); ?></p>
        <?php else: ?>
            <p><strong>Username:</strong> <?= htmlspecialchars($profileData['username'] ?? ''); ?></p>
        <?php endif; ?>

        <p><strong>Phone:</strong> <?= htmlspecialchars($profileData['phone_number'] ?? ''); ?></p>
        <p><strong>Address:</strong> <?= htmlspecialchars($profileData['address'] ?? ''); ?></p>

        <!-- Display profile picture if exists -->
        <?php if (!empty($profileData['profile_picture'])): ?>
            <p><strong>Profile Picture:</strong></p>
            <img src="<?= htmlspecialchars($profileData['profile_picture'], ENT_QUOTES, 'UTF-8'); ?>"
                 alt="Profile Picture"
                 class="w-32 h-32 object-cover rounded border mb-2">
        <?php else: ?>
            <p><em>No profile picture.</em></p>
        <?php endif; ?>
    </div>

    <!-- EDIT FORM (Text fields) -->
    <form action="/profile" method="POST" class="max-w-md bg-white p-6 rounded shadow mb-8">
        <h2 class="text-xl font-semibold mb-4">Edit Profile (Text Fields)</h2>

        <!-- EMAIL -->
        <div class="mb-4">
            <label class="block mb-1 font-semibold" for="email">Email</label>
            <input 
                type="email"
                name="email"
                id="email"
                value="<?= htmlspecialchars($profileData['email'] ?? ''); ?>"
                class="w-full border border-gray-300 rounded px-3 py-2"
            >
        </div>

        <!-- USERNAME or NAME -->
        <?php if ($role === 'hairdresser'): ?>
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
        <?php else: ?>
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

        <!-- Optional Specialization if hairdresser -->
        <?php if ($role === 'hairdresser'): ?>
            <div class="mb-4">
                <label class="block mb-1 font-semibold" for="specialization">Specialization</label>
                <input
                    type="text"
                    name="specialization"
                    id="specialization"
                    value="<?= htmlspecialchars($profileData['specialization'] ?? ''); ?>"
                    class="w-full border border-gray-300 rounded px-3 py-2"
                >
            </div>
        <?php endif; ?>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Save Changes
        </button>
    </form>

    <!-- FILE UPLOAD FORM (AJAX) -->
    <div class="max-w-md bg-white p-6 rounded shadow">
        <h2 class="text-xl font-semibold mb-4">Upload Profile Picture</h2>

        <div class="mb-4">
            <label class="block mb-1 font-semibold" for="profilePic">Choose a File</label>
            <input type="file" id="profilePic" name="profilePic" accept="image/*" class="border border-gray-300 p-2">
        </div>

        <button id="uploadBtn" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            Upload Picture
        </button>

        <div id="uploadMsg" class="mt-4 text-green-600"></div>
    </div>
</div>

<!-- Include the JS for file uploads -->
<script src="/assets/js/profile_upload.js"></script>

<?php require(__DIR__ . '/../partials/footer.php'); ?>