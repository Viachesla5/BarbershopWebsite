<?php require(__DIR__ . '/../partials/header.php'); ?>

<div class="min-h-screen bg-dark-200">
    <div class="container mx-auto px-4 py-12">
        <div class="max-w-2xl mx-auto">
            <h1 class="text-3xl font-bold mb-8 text-white text-center">Hairdresser Profile</h1>

            <?php if (!empty($hairdresser)): ?>
                <div class="bg-dark-100 p-8 rounded-xl shadow-lg border border-dark-50">
                    <div class="flex flex-col items-center mb-8">
                        <?php if (!empty($hairdresser['profile_picture'])): ?>
                            <img src="<?= htmlspecialchars($hairdresser['profile_picture']); ?>" 
                                 alt="Profile Picture" 
                                 class="w-40 h-40 object-cover rounded-full border-4 border-dark-50 shadow-lg">
                        <?php endif; ?>
                    </div>

                    <div class="space-y-6">
                        <div class="flex items-center space-x-4">
                            <span class="text-gray-200 font-semibold w-32">Name:</span>
                            <span class="text-gray-300"><?= htmlspecialchars($hairdresser['name']); ?></span>
                        </div>
                        <div class="flex items-center space-x-4">
                            <span class="text-gray-200 font-semibold w-32">Specialization:</span>
                            <span class="text-blue-400"><?= htmlspecialchars($hairdresser['specialization']); ?></span>
                        </div>
                        <div class="flex items-center space-x-4">
                            <span class="text-gray-200 font-semibold w-32">Phone:</span>
                            <span class="text-gray-300"><?= htmlspecialchars($hairdresser['phone_number'] ?? 'Not provided'); ?></span>
                        </div>

                        <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']): ?>
                            <!-- Admin-only information -->
                            <div class="border-t border-dark-50 pt-6 mt-6">
                                <h3 class="text-xl font-semibold text-gray-200 mb-4">Admin Details</h3>
                                <div class="space-y-4">
                                    <div class="flex items-center space-x-4">
                                        <span class="text-gray-200 font-semibold w-32">ID:</span>
                                        <span class="text-gray-300"><?= htmlspecialchars((string)$hairdresser['id']); ?></span>
                                    </div>
                                    <div class="flex items-center space-x-4">
                                        <span class="text-gray-200 font-semibold w-32">Email:</span>
                                        <span class="text-gray-300"><?= htmlspecialchars($hairdresser['email']); ?></span>
                                    </div>
                                    <div class="flex items-center space-x-4">
                                        <span class="text-gray-200 font-semibold w-32">Address:</span>
                                        <span class="text-gray-300"><?= htmlspecialchars($hairdresser['address'] ?? 'Not provided'); ?></span>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="mt-8 text-center">
                    <a href="/hairdressers" 
                       class="inline-block bg-dark-100 text-gray-200 px-6 py-3 rounded-lg hover:bg-dark-300 transition duration-200">
                        Back to Hairdressers
                    </a>
                </div>
            <?php else: ?>
                <div class="text-center">
                    <p class="text-gray-300 text-lg">Hairdresser not found.</p>
                    <a href="/hairdressers" 
                       class="inline-block mt-4 bg-dark-100 text-gray-200 px-6 py-3 rounded-lg hover:bg-dark-300 transition duration-200">
                        Back to Hairdressers
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require(__DIR__ . '/../partials/footer.php'); ?>