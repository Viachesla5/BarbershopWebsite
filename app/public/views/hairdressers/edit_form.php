<?php require(__DIR__ . '/../partials/header.php'); ?>

<div class="container mx-auto mt-8">
    <h1 class="text-2xl font-bold mb-4">Edit Hairdresser #<?= htmlspecialchars($hairdresser['id']); ?></h1>

    <form 
        action="/hairdressers/edit/<?= htmlspecialchars($hairdresser['id']); ?>" 
        method="POST" 
        class="max-w-md bg-white p-6 rounded shadow"
    >
        <!-- EMAIL -->
        <div class="mb-4">
            <label class="block mb-1 font-semibold" for="email">Email</label>
            <input 
                type="email" 
                name="email" 
                id="email"
                value="<?= htmlspecialchars($hairdresser['email']); ?>"
                class="w-full border border-gray-300 rounded px-3 py-2"
                required
            >
        </div>

        <!-- NAME -->
        <div class="mb-4">
            <label class="block mb-1 font-semibold" for="name">Name</label>
            <input 
                type="text" 
                name="name" 
                id="name"
                value="<?= htmlspecialchars($hairdresser['name']); ?>"
                class="w-full border border-gray-300 rounded px-3 py-2"
                required
            >
        </div>

        <!-- PASSWORD -->
        <!-- Typically you'd handle password changes in a separate field or leave it blank if not changing -->
        <!-- For simplicity, you can omit or add a new password field: -->
        <!-- <div class="mb-4">
            <label class="block mb-1 font-semibold" for="new_password">New Password (leave empty if not changing)</label>
            <input
                type="password"
                name="new_password"
                id="new_password"
                class="w-full border border-gray-300 rounded px-3 py-2"
            >
        </div> -->

        <!-- PHONE NUMBER -->
        <div class="mb-4">
            <label class="block mb-1 font-semibold" for="phone_number">Phone Number</label>
            <input 
                type="text" 
                name="phone_number"
                id="phone_number"
                value="<?= htmlspecialchars($hairdresser['phone_number']); ?>"
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
                value="<?= htmlspecialchars($hairdresser['address']); ?>"
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
                value="<?= htmlspecialchars($hairdresser['profile_picture']); ?>"
                class="w-full border border-gray-300 rounded px-3 py-2"
            >
        </div>

        <!-- SPECIALIZATION -->
        <div class="mb-4">
            <label class="block mb-1 font-semibold" for="specialization">Specialization</label>
            <input 
                type="text" 
                name="specialization"
                id="specialization"
                value="<?= htmlspecialchars($hairdresser['specialization']); ?>"
                class="w-full border border-gray-300 rounded px-3 py-2"
            >
        </div>

        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            Update
        </button>
    </form>
</div>

<?php require(__DIR__ . '/../partials/footer.php'); ?>