<?php require(__DIR__ . '/../partials/header.php'); ?>

<div class="container mx-auto mt-8">
    <h1 class="text-2xl font-bold mb-4">Edit Hairdresser</h1>

    <form action="/admin/hairdressers/edit/<?= $hairdresser['id']; ?>" method="POST" class="max-w-md bg-white p-6 rounded shadow">
        
        <!-- EMAIL -->
        <div class="mb-4">
            <label for="email" class="block mb-1 font-semibold">Email</label>
            <input 
                type="email" 
                name="email" 
                id="email" 
                value="<?= htmlspecialchars($hairdresser['email']); ?>"
                class="w-full border border-gray-300 px-3 py-2"
            >
        </div>

        <!-- NAME -->
        <div class="mb-4">
            <label for="name" class="block mb-1 font-semibold">Name</label>
            <input 
                type="text" 
                name="name" 
                id="name" 
                value="<?= htmlspecialchars($hairdresser['name']); ?>"
                class="w-full border border-gray-300 px-3 py-2"
            >
        </div>

        <!-- NEW PASSWORD -->
        <div class="mb-4">
            <label for="password" class="block mb-1 font-semibold">
                New Password (leave blank to keep existing)
            </label>
            <input 
                type="password" 
                name="password" 
                id="password" 
                class="w-full border border-gray-300 px-3 py-2"
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

        <!-- SPECIALIZATION -->
        <div class="mb-4">
            <label for="specialization" class="block mb-1 font-semibold">Specialization</label>
            <input 
                type="text" 
                name="specialization"
                id="specialization"
                value="<?= htmlspecialchars($hairdresser['specialization']); ?>"
                class="w-full border border-gray-300 px-3 py-2"
            >
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Save Changes
        </button>
    </form>
</div>

<?php require(__DIR__ . '/../partials/footer.php'); ?>