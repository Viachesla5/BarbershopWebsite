<?php require(__DIR__ . '/../partials/header.php'); ?>

<div class="container mx-auto mt-8 p-6">
    <h1 class="text-2xl font-bold mb-6 text-white">Edit Appointment #<?= htmlspecialchars($appointment['id']); ?></h1>

    <form 
        action="/appointments/edit/<?= htmlspecialchars($appointment['id']); ?>" 
        method="POST" 
        class="max-w-md bg-dark-100 p-6 rounded shadow-lg border border-dark-50"
    >
        <!-- USER DROPDOWN -->
        <div class="mb-4">
            <label class="block mb-1 font-semibold text-gray-200" for="user_id">Select User</label>
            <select name="user_id" id="user_id" class="w-full bg-dark-200 text-white border border-dark-50 rounded px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500" required>
                <option value="" disabled class="bg-dark-200">-- Select User --</option>
                <?php foreach ($allUsers as $u): ?>
                    <option value="<?= htmlspecialchars($u['id']); ?>"
                        <?php if ($u['id'] == $appointment['user_id']) echo 'selected'; ?>
                        class="bg-dark-200">
                        <?= htmlspecialchars($u['username']); ?> (ID: <?= $u['id']; ?>)
                    </option>
                <?php endforeach; ?>
            </select>
            <p class="text-red-400 text-sm mt-1">Required</p>
        </div>

        <!-- HAIRDRESSER DROPDOWN -->
        <div class="mb-4">
            <label class="block mb-1 font-semibold text-gray-200" for="hairdresser_id">Select Hairdresser</label>
            <select name="hairdresser_id" id="hairdresser_id" class="w-full bg-dark-200 text-white border border-dark-50 rounded px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500" required>
                <option value="" disabled class="bg-dark-200">-- Select Hairdresser --</option>
                <?php foreach ($allHairdressers as $h): ?>
                    <option value="<?= htmlspecialchars($h['id']); ?>"
                        <?php if ($h['id'] == $appointment['hairdresser_id']) echo 'selected'; ?>
                        class="bg-dark-200">
                        <?= htmlspecialchars($h['name']); ?> (ID: <?= $h['id']; ?>)
                    </option>
                <?php endforeach; ?>
            </select>
            <p class="text-red-400 text-sm mt-1">Required</p>
        </div>

        <!-- DATE -->
        <div class="mb-4">
            <label class="block mb-1 font-semibold text-gray-200" for="appointment_date">Appointment Date</label>
            <input
                type="date"
                name="appointment_date"
                id="appointment_date"
                value="<?= htmlspecialchars($appointment['appointment_date']); ?>"
                class="w-full bg-dark-200 text-white border border-dark-50 rounded px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                required
            >
            <p class="text-red-400 text-sm mt-1">Required</p>
        </div>

        <!-- TIME -->
        <div class="mb-4">
            <label class="block mb-1 font-semibold text-gray-200" for="appointment_time">Appointment Time</label>
            <input
                type="time"
                name="appointment_time"
                id="appointment_time"
                value="<?= htmlspecialchars($appointment['appointment_time']); ?>"
                class="w-full bg-dark-200 text-white border border-dark-50 rounded px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                required
            >
            <p class="text-red-400 text-sm mt-1">Required</p>
        </div>

        <!-- STATUS -->
        <div class="mb-4">
            <label class="block mb-1 font-semibold text-gray-200" for="status">Status</label>
            <select name="status" id="status" class="w-full bg-dark-200 text-white border border-dark-50 rounded px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                <option value="upcoming"  <?php if ($appointment['status'] === 'upcoming')  echo 'selected'; ?> class="bg-dark-200">Upcoming</option>
                <option value="completed" <?php if ($appointment['status'] === 'completed') echo 'selected'; ?> class="bg-dark-200">Completed</option>
                <option value="canceled"  <?php if ($appointment['status'] === 'canceled')  echo 'selected'; ?> class="bg-dark-200">Canceled</option>
            </select>
        </div>

        <button type="submit" class="w-full bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition duration-200">
            Update Appointment
        </button>
    </form>
</div>

<?php require(__DIR__ . '/../partials/footer.php'); ?>
