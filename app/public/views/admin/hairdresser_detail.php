<?php require(__DIR__ . '/../partials/header.php'); ?>

<div class="container mx-auto mt-8 p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-white">Hairdresser Details</h1>
        <div class="space-x-3">
            <a href="/admin/hairdressers/edit/<?= $hairdresser['id'] ?>" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition duration-200">
                Edit Hairdresser
            </a>
            <a href="/admin/hairdressers" class="bg-dark-200 text-gray-200 px-4 py-2 rounded hover:bg-dark-300 transition duration-200">
                Back to Hairdressers
            </a>
        </div>
    </div>

    <div class="bg-dark-100 rounded-lg shadow-lg p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h2 class="text-lg font-semibold mb-4 text-white">Basic Information</h2>
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-400">Name</label>
                        <p class="mt-1 text-gray-200"><?= $hairdresser['name'] ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-400">Email</label>
                        <p class="mt-1 text-gray-200"><?= $hairdresser['email'] ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-400">Specialization</label>
                        <p class="mt-1">
                            <span class="bg-purple-500 text-white px-2 py-1 rounded text-sm">
                                <?= $hairdresser['specialization'] ?>
                            </span>
                        </p>
                    </div>
                </div>
            </div>
            <div>
                <h2 class="text-lg font-semibold mb-4 text-white">Additional Information</h2>
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-400">Phone Number</label>
                        <p class="mt-1 text-gray-200"><?= $hairdresser['phone_number'] ?? 'Not provided' ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-400">Address</label>
                        <p class="mt-1 text-gray-200"><?= $hairdresser['address'] ?? 'Not provided' ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-400">Created At</label>
                        <p class="mt-1 text-gray-200"><?= $hairdresser['created_at'] ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require(__DIR__ . '/../partials/footer.php'); ?>
