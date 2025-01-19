<?php require(__DIR__ . '/../partials/header.php'); ?>

<div class="container mx-auto mt-8">
    <h1 class="text-2xl font-bold mb-4">User Details</h1>

    <?php if (!empty($user)): ?>
        <div class="bg-white p-6 rounded shadow">
            <p><strong>ID:</strong> <?= htmlspecialchars($user['id']); ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($user['email']); ?></p>
            <p><strong>Username:</strong> <?= htmlspecialchars($user['username']); ?></p>
            <p><strong>Phone Number:</strong> <?= htmlspecialchars($user['phone_number'] ?? 'N/A'); ?></p>
            <p><strong>Address:</strong> <?= htmlspecialchars($user['address'] ?? 'N/A'); ?></p>
            <p><strong>Profile Picture:</strong></p>
            <?php if (!empty($user['profile_picture'])): ?>
                <img src="<?= htmlspecialchars($user['profile_picture']); ?>" alt="Profile Picture" class="w-32 h-32 object-cover rounded border">
            <?php else: ?>
                <p>No profile picture provided.</p>
            <?php endif; ?>
            <p><strong>Is Admin:</strong> <?= $user['is_admin'] ? 'Yes' : 'No'; ?></p>
        </div>
    <?php else: ?>
        <p>User not found.</p>
    <?php endif; ?>

    <div class="mt-4">
        <a href="/admin/users" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Back to Users</a>
    </div>
</div>

<?php require(__DIR__ . '/../partials/footer.php'); ?>