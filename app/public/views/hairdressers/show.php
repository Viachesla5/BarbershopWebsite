<?php require(__DIR__ . '/../partials/header.php'); ?>

<div class="container mx-auto mt-8">
    <h1 class="text-2xl font-bold mb-4">Hairdresser Details</h1>

    <?php if (!empty($hairdresser)): ?>
        <div class="bg-white p-6 rounded shadow max-w-md">
            <p><strong>ID:</strong> <?= htmlspecialchars($hairdresser['id']); ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($hairdresser['email']); ?></p>
            <p><strong>Name:</strong> <?= htmlspecialchars($hairdresser['name']); ?></p>
            <p><strong>Phone:</strong> <?= htmlspecialchars($hairdresser['phone_number']); ?></p>
            <p><strong>Address:</strong> <?= htmlspecialchars($hairdresser['address']); ?></p>
            <p><strong>Specialization:</strong> <?= htmlspecialchars($hairdresser['specialization']); ?></p>

            <?php if (!empty($hairdresser['profile_picture'])): ?>
                <div class="mt-4">
                    <img src="/path/to/uploads/<?= htmlspecialchars($hairdresser['profile_picture']); ?>" 
                         alt="Profile Picture" 
                         class="w-32 h-32 object-cover rounded border">
                </div>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <p>Hairdresser not found.</p>
    <?php endif; ?>

    <div class="mt-4">
        <a href="/hairdressers" class="bg-gray-300 text-black px-4 py-2 rounded hover:bg-gray-400">
            Back to List
        </a>
    </div>
</div>

<?php require(__DIR__ . '/../partials/footer.php'); ?>