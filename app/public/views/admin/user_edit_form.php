<?php require(__DIR__ . '/../partials/header.php'); ?>

<div class="container mx-auto mt-8">
    <h1 class="text-2xl font-bold mb-4">Edit User</h1>

    <form action="/admin/users/edit/<?= $user['id']; ?>" method="POST" class="max-w-md bg-white p-6 rounded shadow">
        <!-- Email -->
        <div class="mb-4">
            <label for="email" class="block mb-1 font-semibold">Email</label>
            <input 
                type="email" 
                name="email" 
                id="email" 
                value="<?= htmlspecialchars($user['email']); ?>"
                class="w-full border border-gray-300 px-3 py-2"
            >
        </div>

        <!-- Username -->
        <div class="mb-4">
            <label for="username" class="block mb-1 font-semibold">Username</label>
            <input 
                type="text" 
                name="username" 
                id="username" 
                value="<?= htmlspecialchars($user['username']); ?>"
                class="w-full border border-gray-300 px-3 py-2"
            >
        </div>

        <!-- Password -->
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

        <!-- Phone Number -->
        <div class="mb-4">
            <label class="block mb-1 font-semibold" for="phone_number">Phone Number</label>
            <input 
                type="text" 
                name="phone_number" 
                id="phone_number" 
                value="<?= htmlspecialchars($user['phone_number'] ?? ''); ?>"
                class="w-full border border-gray-300 px-3 py-2"
            >
        </div>

        <!-- Address -->
        <div class="mb-4">
            <label class="block mb-1 font-semibold" for="address">Address</label>
            <input 
                type="text" 
                name="address" 
                id="address" 
                value="<?= htmlspecialchars($user['address'] ?? ''); ?>"
                class="w-full border border-gray-300 px-3 py-2"
            >
        </div>

        <!-- Profile Picture -->
        <div class="mb-4">
            <label class="block mb-1 font-semibold" for="profile_picture">Profile Picture</label>
            <input 
                type="text" 
                name="profile_picture" 
                id="profile_picture" 
                value="<?= htmlspecialchars($user['profile_picture'] ?? ''); ?>"
                class="w-full border border-gray-300 px-3 py-2"
            >
        </div>

        <!-- Admin Checkbox -->
        <div class="mb-4">
            <label class="inline-flex items-center">
                <input 
                    type="checkbox" 
                    name="is_admin" 
                    value="1"
                    <?php if ($user['is_admin']) echo 'checked'; ?>
                    class="mr-2"
                >
                <span class="font-semibold">Is Admin</span>
            </label>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Save Changes
        </button>
    </form>
</div>

<?php require(__DIR__ . '/../partials/footer.php'); ?>