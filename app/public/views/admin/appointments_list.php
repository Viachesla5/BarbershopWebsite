<?php require(__DIR__ . '/../partials/header.php'); ?>

<div class="container mx-auto mt-8 p-6">
    <h1 class="text-2xl font-bold mb-6 text-white">Manage Appointments</h1>

    <?php if (empty($appointments)) : ?>
        <p class="text-gray-300">No appointments found.</p>
    <?php else : ?>
        <div class="bg-dark-100 rounded-lg shadow-lg overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-dark-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-200">ID</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-200">User</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-200">Hairdresser</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-200">Date</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-200">Time</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-200">Status</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-200">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-dark-50">
                    <?php foreach ($appointments as $appointment) : ?>
                        <tr class="hover:bg-dark-200 transition duration-150">
                            <td class="px-6 py-4 text-sm text-gray-300"><?= $appointment['id'] ?></td>
                            <td class="px-6 py-4 text-sm text-gray-300"><?= htmlspecialchars($appointment['user_name']) ?></td>
                            <td class="px-6 py-4 text-sm text-gray-300"><?= htmlspecialchars($appointment['hairdresser_name']) ?></td>
                            <td class="px-6 py-4 text-sm text-gray-300"><?= $appointment['appointment_date'] ?></td>
                            <td class="px-6 py-4 text-sm text-gray-300"><?= $appointment['appointment_time'] ?></td>
                            <td class="px-6 py-4 text-sm text-gray-300">
                                <?php
                                $statusClass = match($appointment['status']) {
                                    'upcoming' => 'text-yellow-400',
                                    'completed' => 'text-green-400',
                                    'cancelled' => 'text-red-400',
                                    default => 'text-gray-300'
                                };
                                ?>
                                <span class="<?= $statusClass ?>"><?= ucfirst($appointment['status']) ?></span>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <a href="/admin/appointments/edit/<?= $appointment['id'] ?>" class="text-blue-400 hover:text-blue-500 mr-3">Edit</a>
                                <a href="/admin/appointments/delete/<?= $appointment['id'] ?>" class="text-red-400 hover:text-red-500" onclick="return confirm('Are you sure you want to delete this appointment?')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php require(__DIR__ . '/../partials/footer.php'); ?>