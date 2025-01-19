<?php require(__DIR__ . '/../partials/header.php'); ?>

<div class="container mx-auto mt-8">
    <h1 class="text-2xl font-bold mb-4">Create New User</h1>

    <form action="/admin/users/create" method="POST" class="max-w-md bg-white p-6 rounded shadow">
        <!-- Email -->
        <div class="mb-4">
            <label class="block mb-1 font-semibold" for="email">Email</label>
            <input type="email" name="email" id="email" class="w-full border border-gray-300 px-3 py-2" required>
            <p class="text-red-500 text-sm mt-1">Required</p>
        </div>

        <!-- Username -->
        <div class="mb-4">
            <label class="block mb-1 font-semibold" for="username">Username</label>
            <input type="text" name="username" id="username" class="w-full border border-gray-300 px-3 py-2" required>
            <p class="text-red-500 text-sm mt-1">Required</p>
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label class="block mb-1 font-semibold" for="password">Password</label>
            <input type="password" name="password" id="password" class="w-full border border-gray-300 px-3 py-2" required>
            <p class="text-red-500 text-sm mt-1">Required</p>
        </div>

        <!-- Phone Number -->
        <div class="mb-4">
            <label class="block mb-1 font-semibold" for="phone_number">Phone Number</label>
            <input type="text" name="phone_number" id="phone_number" class="w-full border border-gray-300 px-3 py-2">
            <p class="text-gray-500 text-sm mt-1">Optional</p>
        </div>

        <!-- Address -->
        <div class="mb-4">
            <label class="block mb-1 font-semibold" for="address">Address</label>
            <input type="text" name="address" id="address" class="w-full border border-gray-300 px-3 py-2">
            <p class="text-gray-500 text-sm mt-1">Optional</p>
        </div>

        <!-- Profile Picture -->
        <div class="mb-4">
            <label class="block mb-1 font-semibold" for="profile_picture">Profile Picture</label>
            <input type="text" name="profile_picture" id="profile_picture" class="w-full border border-gray-300 px-3 py-2" placeholder="File path or URL">
            <p class="text-gray-500 text-sm mt-1">Optional</p>
        </div>

        <!-- Admin Checkbox -->
        <div class="mb-4">
            <label class="inline-flex items-center">
                <input type="checkbox" name="is_admin" value="1" class="mr-2">
                <span class="font-semibold">Is Admin</span>
            </label>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Create User
        </button>
    </form>
</div>

<?php require(__DIR__ . '/../partials/footer.php'); ?>