<?php require(__DIR__ . '/../partials/header.php'); ?>

<div class="container mx-auto mt-8 p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-white">Manage Hairdressers</h1>
        <a href="/admin/hairdressers/create" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition duration-200">
            Add New Hairdresser
        </a>
    </div>

    <?php if (empty($hairdressers)) : ?>
        <p class="text-gray-300">No hairdressers found.</p>
    <?php else : ?>
        <div class="bg-dark-100 rounded-lg shadow-lg overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-dark-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-200">ID</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-200">Name</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-200">Email</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-200">Specialization</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-200">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-dark-50">
                    <?php foreach ($hairdressers as $hairdresser) : ?>
                        <tr class="hover:bg-dark-200 transition duration-150">
                            <td class="px-6 py-4 text-sm text-gray-300"><?= $hairdresser['id'] ?></td>
                            <td class="px-6 py-4 text-sm text-gray-300"><?= $hairdresser['name'] ?></td>
                            <td class="px-6 py-4 text-sm text-gray-300"><?= $hairdresser['email'] ?></td>
                            <td class="px-6 py-4 text-sm text-gray-300"><?= $hairdresser['specialization'] ?></td>
                            <td class="px-6 py-4 text-sm space-x-3">
                                <a href="/admin/hairdressers/edit/<?= $hairdresser['id'] ?>" class="text-blue-400 hover:text-blue-500">Edit</a>
                                <a href="/admin/hairdressers/delete/<?= $hairdresser['id'] ?>" class="text-red-400 hover:text-red-500" onclick="return confirm('Are you sure you want to delete this hairdresser?')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php require(__DIR__ . '/../partials/footer.php'); ?>