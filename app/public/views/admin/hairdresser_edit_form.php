<?php require(__DIR__ . '/../partials/header.php'); ?>

<div class="container mx-auto mt-8 flex justify-center">
    <!-- EDIT FORM (Combined) -->
    <form id="profileForm" action="/admin/hairdressers/edit/<?= $hairdresser['id'] ?>" method="POST" class="w-full max-w-md bg-dark-100 p-6 rounded shadow-lg border border-dark-50">
        <h2 class="text-2xl font-bold mb-6 text-center text-white">
            Edit Hairdresser Profile
        </h2>

        <!-- SHOW SUCCESS MESSAGE IF ANY -->
        <?php if (isset($success)): ?>
            <div class="mb-4 text-green-400 bg-green-900/20 p-3 rounded text-center">
                <?= htmlspecialchars($success); ?>
            </div>
        <?php endif; ?>

        <!-- Profile Picture Section -->
        <div class="mb-8 text-center">
            <label class="block mb-2 font-semibold text-gray-200">Profile Picture</label>
            <div id="profilePictureContainer" class="mb-2 inline-block" onclick="document.getElementById('profile_picture').click();">
                <?php if (!empty($hairdresser['profile_picture'])): ?>
                    <div class="hover-trigger">
                        <img src="<?= htmlspecialchars($hairdresser['profile_picture'], ENT_QUOTES, 'UTF-8'); ?>"
                             alt="Current Profile Picture"
                             class="w-32 h-32 object-cover rounded border border-dark-50">
                        <div class="hover-overlay">
                            <span class="text-white px-2 py-1 rounded bg-black bg-opacity-50">Click to change</span>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="w-32 h-32 border-2 border-dashed border-dark-50 rounded flex items-center justify-center mx-auto hover:bg-dark-200 hover:border-dark-25 cursor-pointer transition-colors duration-200">
                        <span class="text-gray-400">Click to upload</span>
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
            <p class="text-sm text-gray-400 mt-1">Supported formats: JPG, PNG, GIF (max 5MB)</p>
            <div id="uploadStatus" class="mt-2 text-sm"></div>
        </div>

        <!-- Email -->
        <div class="mb-4">
            <label class="block mb-1 font-semibold text-gray-200" for="email">Email</label>
            <input 
                type="email"
                name="email"
                id="email"
                value="<?= htmlspecialchars($hairdresser['email'] ?? ''); ?>"
                class="w-full bg-dark-200 text-white border border-dark-50 rounded px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                required
            >
        </div>

        <!-- Name -->
        <div class="mb-4">
            <label class="block mb-1 font-semibold text-gray-200" for="name">Name</label>
            <input
                type="text"
                name="name"
                id="name"
                value="<?= htmlspecialchars($hairdresser['name'] ?? ''); ?>"
                class="w-full bg-dark-200 text-white border border-dark-50 rounded px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                required
            >
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label class="block mb-1 font-semibold text-gray-200" for="password">
                New Password (leave blank to keep current)
            </label>
            <input
                type="password"
                name="password"
                id="password"
                class="w-full bg-dark-200 text-white border border-dark-50 rounded px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
            >
        </div>

        <!-- Specialization -->
        <div class="mb-4">
            <label class="block mb-1 font-semibold text-gray-200" for="specialization">Specialization</label>
            <input
                type="text"
                name="specialization"
                id="specialization"
                value="<?= htmlspecialchars($hairdresser['specialization'] ?? ''); ?>"
                class="w-full bg-dark-200 text-white border border-dark-50 rounded px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                required
            >
        </div>

        <!-- Phone Number -->
        <div class="mb-4">
            <label class="block mb-1 font-semibold text-gray-200" for="phone_number">Phone Number</label>
            <input
                type="text"
                name="phone_number"
                id="phone_number"
                value="<?= htmlspecialchars($hairdresser['phone_number'] ?? ''); ?>"
                class="w-full bg-dark-200 text-white border border-dark-50 rounded px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
            >
        </div>

        <!-- Address -->
        <div class="mb-4">
            <label class="block mb-1 font-semibold text-gray-200" for="address">Address</label>
            <input
                type="text"
                name="address"
                id="address"
                value="<?= htmlspecialchars($hairdresser['address'] ?? ''); ?>"
                class="w-full bg-dark-200 text-white border border-dark-50 rounded px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
            >
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition duration-200">
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
            uploadStatus.className = 'mt-2 text-sm text-blue-400';

            fetch('/admin/hairdressers/uploadPicture/<?= $hairdresser['id'] ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    uploadStatus.textContent = 'Upload successful!';
                    uploadStatus.className = 'mt-2 text-sm text-green-400';
                    
                    // Update the profile picture preview with hover effect
                    profilePictureContainer.innerHTML = `
                        <div class="hover-trigger">
                            <img src="${data.filePath}"
                                 alt="Profile Picture"
                                 class="w-32 h-32 object-cover rounded border border-dark-50">
                            <div class="hover-overlay">
                                <span class="text-white px-2 py-1 rounded bg-black bg-opacity-50">Click to change</span>
                            </div>
                        </div>
                    `;
                } else {
                    uploadStatus.textContent = 'Upload failed: ' + data.message;
                    uploadStatus.className = 'mt-2 text-sm text-red-400';
                }
            })
            .catch(error => {
                uploadStatus.textContent = 'Upload failed: ' + error.message;
                uploadStatus.className = 'mt-2 text-sm text-red-400';
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