<?php require(__DIR__ . '/../partials/header.php'); ?>

<div class="container mx-auto mt-8 p-6">
    <h1 class="text-2xl font-bold mb-6 text-white">All Hairdressers</h1>

    <?php if (!empty($hairdressers)): ?>
        <div class="overflow-x-auto rounded-lg border border-dark-50">
            <table class="min-w-full bg-dark-100">
                <thead>
                    <tr class="bg-dark-200 border-b border-dark-50">
                        <th class="py-3 px-4 text-gray-200">Email</th>
                        <th class="py-3 px-4 text-gray-200">Name</th>
                        <th class="py-3 px-4 text-gray-200">Specialization</th>
                        <th class="py-3 px-4 text-gray-200">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($hairdressers as $h): ?>
                        <tr class="border-b border-dark-50 hover:bg-dark-200 transition-colors duration-150">
                            <td class="py-3 px-4 text-gray-300">
                                <?= htmlspecialchars($h['email']); ?>
                            </td>
                            <td class="py-3 px-4 text-gray-300">
                                <?= htmlspecialchars($h['name']); ?>
                            </td>
                            <td class="py-3 px-4 text-gray-300">
                                <?= htmlspecialchars($h['specialization']); ?>
                            </td>
                            <td class="py-3 px-4 text-center">
                                <!-- Show link is visible to everyone -->
                                <a href="/hairdressers/<?= $h['id']; ?>"
                                   class="text-blue-400 hover:text-blue-300 transition-colors duration-150 mr-3">
                                    Show
                                </a>

                                <?php
                                // Only show Edit/Delete if admin session is set
                                if (!empty($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1): 
                                ?>
                                    <a href="/hairdressers/edit/<?= $h['id']; ?>"
                                       class="text-green-400 hover:text-green-300 transition-colors duration-150 mr-3">
                                        Edit
                                    </a>
                                    <a href="/hairdressers/delete/<?= $h['id']; ?>"
                                       class="text-red-400 hover:text-red-300 transition-colors duration-150"
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
        <p class="text-gray-300">No hairdressers found.</p>
    <?php endif; ?>
</div>

<?php require(__DIR__ . '/../partials/footer.php'); ?>