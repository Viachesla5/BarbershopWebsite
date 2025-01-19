<?php require(__DIR__ . '/../partials/header.php'); ?>

<div class="container mx-auto mt-8">
    <h1 class="text-2xl font-bold mb-4">Hairdresser Details</h1>

    <div class="bg-gray-100 p-4 rounded shadow">
        <p><strong>Email:</strong> <?= htmlspecialchars($hairdresser['email']); ?></p>
        <p><strong>Name:</strong> <?= htmlspecialchars($hairdresser['name']); ?></p>
        <p><strong>Specialization:</strong> <?= htmlspecialchars($hairdresser['specialization']); ?></p>
        <p><strong>Phone Number:</strong> <?= htmlspecialchars($hairdresser['phone_number'] ?? 'N/A'); ?></p>
        <p><strong>Address:</strong> <?= htmlspecialchars($hairdresser['address'] ?? 'N/A'); ?></p>
        <?php if (!empty($hairdresser['profile_picture'])): ?>
            <div class="mt-4">
                <p><strong>Profile Picture:</strong></p>
                <img src="<?= htmlspecialchars($hairdresser['profile_picture']); ?>" alt="Profile Picture"
                     class="w-32 h-32 object-cover rounded border">
            </div>
        <?php endif; ?>
    </div>

    <div class="mt-4">
        <a href="/admin/hairdressers" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Back to List
        </a>
    </div>
</div>

<?php require(__DIR__ . '/../partials/footer.php'); ?>
