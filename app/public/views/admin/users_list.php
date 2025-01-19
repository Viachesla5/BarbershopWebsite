<?php require(__DIR__ . '/../partials/header.php'); ?>

<div class="container mx-auto mt-8">
    <h1 class="text-2xl font-bold mb-4">Manage Users</h1>

    <div class="mb-4">
        <a href="/admin/users/create" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Create New User
        </a>
    </div>

    <?php if (!empty($users)): ?>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="py-2 px-4 border-b">ID</th>
                        <th class="py-2 px-4 border-b">Email</th>
                        <th class="py-2 px-4 border-b">Username</th>
                        <th class="py-2 px-4 border-b">Is Admin</th>
                        <th class="py-2 px-4 border-b">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $u): ?>
                        <tr>
                            <td class="py-2 px-4 border-b text-center"><?= htmlspecialchars($u['id']); ?></td>
                            <td class="py-2 px-4 border-b"><?= htmlspecialchars($u['email']); ?></td>
                            <td class="py-2 px-4 border-b"><?= htmlspecialchars($u['username']); ?></td>
                            <td class="py-2 px-4 border-b text-center"><?= $u['is_admin'] ? 'Yes' : 'No'; ?></td>
                            <td class="py-2 px-4 border-b text-center">
                                <!-- For editing user details or toggling admin, etc. -->
                                <a href="/admin/users/show/<?= $u['id']; ?>" class="text-blue-500 hover:underline mr-2">Show</a>
                                <a href="/admin/users/edit/<?= $u['id']; ?>" class="text-green-500 hover:underline mr-2">Edit</a>
                                <a href="/admin/users/delete/<?= $u['id']; ?>" class="text-red-500 hover:underline"
                                   onclick="return confirm('Are you sure you want to delete this user?');">
                                   Delete
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p>No users found.</p>
    <?php endif; ?>
</div>

<?php require(__DIR__ . '/../partials/footer.php'); ?>