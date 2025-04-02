<?php require(__DIR__ . '/../partials/header.php'); ?>

<!-- Add the JavaScript file -->
<script src="/assets/js/user_management.js"></script>

<div class="container mx-auto mt-8 p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-white">Manage Users</h1>
        <a href="/admin/users/create" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition duration-200">
            Add New User
        </a>
    </div>

    <?php if (empty($users)) : ?>
        <p class="text-gray-300">No users found.</p>
    <?php else : ?>
        <div class="bg-dark-100 rounded-lg shadow-lg overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-dark-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-200">ID</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-200">Username</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-200">Email</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-200">Role</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-200">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-dark-50">
                    <?php foreach ($users as $user) : ?>
                        <tr class="hover:bg-dark-200 transition duration-150">
                            <td class="px-6 py-4 text-sm text-gray-300"><?= $user['id'] ?></td>
                            <td class="px-6 py-4 text-sm text-gray-300"><?= $user['username'] ?></td>
                            <td class="px-6 py-4 text-sm text-gray-300"><?= $user['email'] ?></td>
                            <td class="px-6 py-4 text-sm">
                                <span class="<?= $user['is_admin'] ? 'bg-purple-500' : 'bg-blue-500' ?> text-white px-2 py-1 rounded text-xs">
                                    <?= $user['is_admin'] ? 'Admin' : 'User' ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm space-x-3">
                                <a href="/admin/users/edit/<?= $user['id'] ?>" class="text-blue-400 hover:text-blue-500">Edit</a>
                                <button 
                                    class="delete-user-btn text-red-400 hover:text-red-500" 
                                    data-user-id="<?= $user['id'] ?>"
                                >
                                    Delete
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php require(__DIR__ . '/../partials/footer.php'); ?>