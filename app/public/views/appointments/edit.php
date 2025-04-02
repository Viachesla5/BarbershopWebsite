<?php require(__DIR__ . '/../partials/header.php'); ?>

<div class="container mx-auto mt-8 p-6">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold text-white mb-6">Edit Appointment</h1>

        <?php if (!empty($errors)): ?>
            <div class="bg-red-500 text-white p-4 rounded-lg mb-6">
                <ul class="list-disc list-inside">
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="/appointments/edit/<?= $appointment['id'] ?>" method="POST" class="bg-dark-100 p-6 rounded-lg shadow-lg">
            <div class="mb-4">
                <label for="user_id" class="block text-gray-300 mb-2">User</label>
                <select name="user_id" id="user_id" required class="w-full p-2 rounded bg-dark-200 text-white border border-gray-600">
                    <?php foreach ($users as $user): ?>
                        <option value="<?= $user['id'] ?>" <?= $user['id'] == $appointment['user_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($user['username']) ?> (<?= htmlspecialchars($user['email']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-4">
                <label for="hairdresser_id" class="block text-gray-300 mb-2">Hairdresser</label>
                <select name="hairdresser_id" id="hairdresser_id" required class="w-full p-2 rounded bg-dark-200 text-white border border-gray-600">
                    <?php foreach ($hairdressers as $hairdresser): ?>
                        <option value="<?= $hairdresser['id'] ?>" <?= $hairdresser['id'] == $appointment['hairdresser_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($hairdresser['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-4">
                <label for="appointment_date" class="block text-gray-300 mb-2">Date</label>
                <input type="date" 
                       name="appointment_date" 
                       id="appointment_date" 
                       value="<?= htmlspecialchars($appointment['appointment_date']) ?>"
                       required
                       class="w-full p-2 rounded bg-dark-200 text-white border border-gray-600">
            </div>

            <div class="mb-4">
                <label for="appointment_time" class="block text-gray-300 mb-2">Time</label>
                <input type="time" 
                       name="appointment_time" 
                       id="appointment_time" 
                       value="<?= htmlspecialchars($appointment['appointment_time']) ?>"
                       required
                       class="w-full p-2 rounded bg-dark-200 text-white border border-gray-600">
            </div>

            <div class="mb-4">
                <label for="status" class="block text-gray-300 mb-2">Status</label>
                <select name="status" id="status" required class="w-full p-2 rounded bg-dark-200 text-white border border-gray-600">
                    <option value="upcoming" <?= $appointment['status'] == 'upcoming' ? 'selected' : '' ?>>Upcoming</option>
                    <option value="completed" <?= $appointment['status'] == 'completed' ? 'selected' : '' ?>>Completed</option>
                    <option value="cancelled" <?= $appointment['status'] == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                </select>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="/appointments" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 transition duration-200">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition duration-200">
                    Update Appointment
                </button>
            </div>
        </form>
    </div>
</div>

<?php require(__DIR__ . '/../partials/footer.php'); ?> 