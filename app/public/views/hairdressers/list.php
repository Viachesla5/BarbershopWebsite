<?php require(__DIR__ . '/../partials/header.php'); ?>

<div class="container mx-auto mt-8 p-6">
    <h1 class="text-2xl font-bold mb-6 text-white">All Hairdressers</h1>

    <?php if (!empty($hairdressers)): ?>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <?php foreach ($hairdressers as $hairdresser): ?>
                <div class="bg-dark-100 p-6 rounded shadow-lg border border-dark-50 hover:shadow-xl transition-shadow">
                    <img 
                        src="<?= htmlspecialchars($hairdresser['profile_picture'] ?? '/assets/images/default-profile.png'); ?>" 
                        alt="<?= htmlspecialchars($hairdresser['name']); ?>" 
                        class="mx-auto rounded-full w-32 h-32 object-cover mb-4 border border-dark-50"
                    >
                    <h3 class="text-xl font-semibold text-white text-center"><?= htmlspecialchars($hairdresser['name']); ?></h3>
                    <p class="text-blue-400 text-center mb-4"><?= htmlspecialchars($hairdresser['specialization'] ?? 'General Styling'); ?></p>
                    
                    <div class="flex justify-center space-x-4">
                        <a href="/hairdressers/<?= htmlspecialchars($hairdresser['id']); ?>" 
                           class="text-blue-400 hover:text-blue-300 transition-colors duration-150">
                            View Profile
                        </a>

                        <?php if (!empty($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1): ?>
                            <a href="/hairdressers/edit/<?= htmlspecialchars($hairdresser['id']); ?>"
                               class="text-green-400 hover:text-green-300 transition-colors duration-150">
                                Edit
                            </a>
                            <a href="/hairdressers/delete/<?= htmlspecialchars($hairdresser['id']); ?>"
                               class="text-red-400 hover:text-red-300 transition-colors duration-150"
                               onclick="return confirm('Are you sure you want to delete this hairdresser?');">
                                Delete
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="text-gray-300">No hairdressers found.</p>
    <?php endif; ?>
</div>

<?php require(__DIR__ . '/../partials/footer.php'); ?>