<?php require(__DIR__ . '/../partials/header.php'); ?>

<div class="container mx-auto mt-8 p-6">
    <h1 class="text-2xl font-bold mb-6 text-white">Hairdresser Details</h1>

    <?php if (!empty($hairdresser)): ?>
        <div class="bg-dark-100 p-6 rounded shadow-lg border border-dark-50 max-w-md">
            <div class="space-y-4">
                <p class="text-gray-300">
                    <strong class="text-gray-200">ID:</strong> 
                    <?= htmlspecialchars((string)$hairdresser['id']); ?>
                </p>
                <p class="text-gray-300">
                    <strong class="text-gray-200">Email:</strong> 
                    <?= htmlspecialchars($hairdresser['email']); ?>
                </p>
                <p class="text-gray-300">
                    <strong class="text-gray-200">Name:</strong> 
                    <?= htmlspecialchars($hairdresser['name']); ?>
                </p>
                <p class="text-gray-300">
                    <strong class="text-gray-200">Phone:</strong> 
                    <?= htmlspecialchars($hairdresser['phone_number'] ?? 'Not provided'); ?>
                </p>
                <p class="text-gray-300">
                    <strong class="text-gray-200">Address:</strong> 
                    <?= htmlspecialchars($hairdresser['address'] ?? 'Not provided'); ?>
                </p>
                <p class="text-gray-300">
                    <strong class="text-gray-200">Specialization:</strong> 
                    <?= htmlspecialchars($hairdresser['specialization']); ?>
                </p>
            </div>

            <?php if (!empty($hairdresser['profile_picture'])): ?>
                <div class="mt-6">
                    <img src="<?= htmlspecialchars($hairdresser['profile_picture']); ?>" 
                         alt="Profile Picture" 
                         class="w-32 h-32 object-cover rounded border border-dark-50">
                </div>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <p class="text-gray-300">Hairdresser not found.</p>
    <?php endif; ?>

    <div class="mt-6">
        <a href="/hairdressers" 
           class="bg-dark-200 text-gray-200 px-4 py-2 rounded hover:bg-dark-300 transition duration-200">
            Back to List
        </a>
    </div>
</div>

<?php require(__DIR__ . '/../partials/footer.php'); ?>