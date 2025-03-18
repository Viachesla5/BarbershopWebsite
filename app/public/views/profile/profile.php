<?php require(__DIR__ . '/../partials/header.php'); ?>

<div class="container mx-auto mt-8 flex justify-center">
    <!-- EDIT FORM (Combined) -->
    <form id="profileForm" action="/profile" method="POST" class="w-full max-w-md bg-white p-6 rounded shadow">
        <h2 class="text-2xl font-bold mb-6 text-center">
            <?php if ($role === 'admin'): ?>
                Admin Profile
            <?php elseif ($role === 'hairdresser'): ?>
                Hairdresser Profile
            <?php else: ?>
                User Profile
            <?php endif; ?>
        </h2>

        <!-- SHOW SUCCESS MESSAGE IF ANY -->
        <?php if (!empty($successMsg)): ?>
            <div class="mb-4 text-green-500 text-center">
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

        <!-- Profile Picture Section -->
        <div class="mb-8 text-center">
            <label class="block mb-2 font-semibold">Profile Picture</label>
            <div id="profilePictureContainer" class="mb-2 inline-block" onclick="document.getElementById('profile_picture').click();">
                <?php if (!empty($profileData['profile_picture'])): ?>
                    <div class="hover-trigger">
                        <img src="<?= htmlspecialchars($profileData['profile_picture'], ENT_QUOTES, 'UTF-8'); ?>"
                             alt="Current Profile Picture"
                             class="w-32 h-32 object-cover rounded border">
                        <div class="hover-overlay">
                            <span class="text-white px-2 py-1 rounded bg-black bg-opacity-50">Click to change</span>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="w-32 h-32 border-2 border-dashed border-gray-300 rounded flex items-center justify-center mx-auto hover:bg-gray-50 hover:border-gray-400 cursor-pointer transition-colors duration-200">
                        <span class="text-gray-500 text-sm">Click to upload</span>
                    </div>
                <?php endif; ?>
            </div>
            <input
                type="file"
                name="profile_picture"
                id="profile_picture"
                accept="image/*"
                class="hidden"
            >
            <p class="text-sm text-gray-500 mt-1">Supported formats: JPG, PNG, GIF (max 5MB)</p>
            <div id="uploadStatus" class="mt-2 text-sm"></div>
        </div>

        <!-- Rest of the form fields -->
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

        <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Save Profile Information
        </button>
    </form>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const profilePicInput = document.getElementById('profile_picture');
        const uploadStatus = document.getElementById('uploadStatus');
        const profilePictureContainer = document.getElementById('profilePictureContainer');

        profilePicInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;

            const formData = new FormData();
            formData.append('profilePic', file);

            uploadStatus.textContent = 'Uploading...';
            uploadStatus.className = 'mt-2 text-sm text-blue-600';

            fetch('/profile/uploadPicture', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    uploadStatus.textContent = 'Upload successful!';
                    uploadStatus.className = 'mt-2 text-sm text-green-600';
                    
                    // Update the profile picture preview with hover effect
                    profilePictureContainer.innerHTML = `
                        <div class="hover-trigger">
                            <img src="${data.filePath}"
                                 alt="Profile Picture"
                                 class="w-32 h-32 object-cover rounded border">
                            <div class="hover-overlay">
                                <span class="text-white px-2 py-1 rounded bg-black bg-opacity-50">Click to change</span>
                            </div>
                        </div>
                    `;
                } else {
                    uploadStatus.textContent = 'Upload failed: ' + data.message;
                    uploadStatus.className = 'mt-2 text-sm text-red-600';
                }
            })
            .catch(error => {
                uploadStatus.textContent = 'Upload failed: ' + error.message;
                uploadStatus.className = 'mt-2 text-sm text-red-600';
            });
        });

        // Prevent form resubmission on page refresh
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    });
    </script>
</div>

<?php require(__DIR__ . '/../partials/footer.php'); ?>