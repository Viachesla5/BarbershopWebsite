<?php require(__DIR__ . '/../partials/header.php'); ?>

<div class="container mx-auto mt-8">
    <h1 class="text-2xl font-bold mb-4">Manage Hairdressers</h1>

    <div class="mb-4">
        <a href="/admin/hairdressers/create" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Create New Hairdresser
        </a>
    </div>

    <?php if (!empty($hairdressers)): ?>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="py-2 px-4 border-b">Email</th>
                        <th class="py-2 px-4 border-b">Name</th>
                        <th class="py-2 px-4 border-b">Specialization</th>
                        <th class="py-2 px-4 border-b">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($hairdressers as $h): ?>
                        <tr>
                            <td class="py-2 px-4 border-b"><?= htmlspecialchars($h['email']); ?></td>
                            <td class="py-2 px-4 border-b"><?= htmlspecialchars($h['name']); ?></td>
                            <td class="py-2 px-4 border-b"><?= htmlspecialchars($h['specialization']); ?></td>
                            <td class="py-2 px-4 border-b text-center">
                                <a href="/admin/hairdressers/show/<?= $h['id']; ?>" class="text-blue-500 hover:underline mr-2">Show</a>
                                <a href="/admin/hairdressers/edit/<?= $h['id']; ?>" class="text-green-500 hover:underline mr-2">Edit</a>
                                <a href="/admin/hairdressers/delete/<?= $h['id']; ?>" class="text-red-500 hover:underline"
                                onclick="return confirm('Delete hairdresser?');">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p>No hairdressers found.</p>
    <?php endif; ?>
</div>

<?php require(__DIR__ . '/../partials/footer.php'); ?>