<?php require(__DIR__ . '/../partials/header.php'); ?>

<div class="container mx-auto mt-8">
    <h1 class="text-2xl font-bold mb-4">Manage Appointments</h1>

    <?php if (!empty($appointments)): ?>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="py-2 px-4 border-b">ID</th>
                        <th class="py-2 px-4 border-b">User ID</th>
                        <th class="py-2 px-4 border-b">Hairdresser ID</th>
                        <th class="py-2 px-4 border-b">Date</th>
                        <th class="py-2 px-4 border-b">Time</th>
                        <th class="py-2 px-4 border-b">Status</th>
                        <th class="py-2 px-4 border-b">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($appointments as $apt): ?>
                        <tr>
                            <td class="py-2 px-4 border-b text-center"><?= htmlspecialchars($apt['id']); ?></td>
                            <td class="py-2 px-4 border-b text-center"><?= htmlspecialchars($apt['user_id']); ?></td>
                            <td class="py-2 px-4 border-b text-center"><?= htmlspecialchars($apt['hairdresser_id']); ?></td>
                            <td class="py-2 px-4 border-b text-center"><?= htmlspecialchars($apt['appointment_date']); ?></td>
                            <td class="py-2 px-4 border-b text-center"><?= htmlspecialchars($apt['appointment_time']); ?></td>
                            <td class="py-2 px-4 border-b text-center"><?= htmlspecialchars($apt['status']); ?></td>
                            <td class="py-2 px-4 border-b text-center">
                                <form action="/admin/appointments/status/<?= $apt['id']; ?>" method="POST" class="inline">
                                    <select name="status" class="border border-gray-300 rounded px-2 py-1">
                                        <option value="upcoming"  <?= $apt['status'] === 'upcoming' ? 'selected' : '' ?>>Upcoming</option>
                                        <option value="completed" <?= $apt['status'] === 'completed' ? 'selected' : '' ?>>Completed</option>
                                        <option value="canceled"  <?= $apt['status'] === 'canceled'  ? 'selected' : '' ?>>Canceled</option>
                                    </select>
                                    <button type="submit" class="bg-blue-500 text-white px-2 py-1 rounded ml-1 hover:bg-blue-600">
                                        Update
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p>No appointments found.</p>
    <?php endif; ?>
</div>

<?php require(__DIR__ . '/../partials/footer.php'); ?>