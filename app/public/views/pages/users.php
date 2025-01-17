<?php require(__DIR__ . '/../partials/header.php'); ?>

<div class="container mx-auto mt-8">
    <h1 class="text-2xl font-bold mb-4">All Users</h1>

    <?php if (!empty($users)): ?>
        <ul class="list-disc ml-8">
            <?php foreach ($users as $user): ?>
                <li class="mb-2">
                    <a href="/user/<?= $user['id']; ?>" class="text-blue-600 hover:underline">
                        <?= htmlspecialchars($user['username']); ?>
                    </a>
                    (<?= htmlspecialchars($user['email']); ?>)
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No users found.</p>
    <?php endif; ?>
</div>

<?php require(__DIR__ . '/../partials/footer.php'); ?>
