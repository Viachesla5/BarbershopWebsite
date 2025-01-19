<?php require(__DIR__ . '/../partials/header.php'); ?>

<div class="container mx-auto mt-8">
    <h1 class="text-2xl font-bold mb-4">All Hairdressers</h1>

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
                            <td class="py-2 px-4 border-b">
                                <?= htmlspecialchars($h['email']); ?>
                            </td>
                            <td class="py-2 px-4 border-b">
                                <?= htmlspecialchars($h['name']); ?>
                            </td>
                            <td class="py-2 px-4 border-b">
                                <?= htmlspecialchars($h['specialization']); ?>
                            </td>
                            <td class="py-2 px-4 border-b text-center">
                                <!-- Show link is visible to everyone -->
                                <a href="/hairdressers/<?= $h['id']; ?>"
                                   class="text-blue-500 hover:underline mr-2">
                                    Show
                                </a>

                                <?php
                                // ADDED CODE: Only show Edit/Delete if admin session is set
                                // (assuming $_SESSION['is_admin'] == 1 means admin user)
                                if (!empty($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1): 
                                ?>
                                    <a href="/hairdressers/edit/<?= $h['id']; ?>"
                                       class="text-green-500 hover:underline mr-2">
                                        Edit
                                    </a>
                                    <a href="/hairdressers/delete/<?= $h['id']; ?>"
                                       class="text-red-500 hover:underline"
                                       onclick="return confirm('Are you sure you want to delete this hairdresser?');">
                                        Delete
                                    </a>
                                <?php endif; ?>
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