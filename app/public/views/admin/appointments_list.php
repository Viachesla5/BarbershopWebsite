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
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-200">User ID</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-200">Hairdresser ID</th>
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
                            <td class="px-6 py-4 text-sm text-gray-300"><?= $appointment['user_id'] ?></td>
                            <td class="px-6 py-4 text-sm text-gray-300"><?= $appointment['hairdresser_id'] ?></td>
                            <td class="px-6 py-4 text-sm text-gray-300"><?= $appointment['appointment_date'] ?></td>
                            <td class="px-6 py-4 text-sm text-gray-300"><?= $appointment['appointment_time'] ?></td>
                            <td class="px-6 py-4">
                                <form action="/admin/appointments/update-status" method="POST" class="flex items-center space-x-2">
                                    <input type="hidden" name="appointment_id" value="<?= $appointment['id'] ?>">
                                    <select name="status" class="bg-dark-200 text-white border border-dark-50 rounded px-2 py-1 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                        <option value="upcoming" <?= $appointment['status'] === 'upcoming' ? 'selected' : '' ?> class="bg-dark-200">
                                            Upcoming
                                        </option>
                                        <option value="completed" <?= $appointment['status'] === 'completed' ? 'selected' : '' ?> class="bg-dark-200">
                                            Completed
                                        </option>
                                        <option value="canceled" <?= $appointment['status'] === 'canceled' ? 'selected' : '' ?> class="bg-dark-200">
                                            Canceled
                                        </option>
                                    </select>
                                    <button type="submit" class="bg-blue-600 text-white px-2 py-1 rounded text-sm hover:bg-blue-700 transition duration-150">
                                        Update
                                    </button>
                                </form>
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