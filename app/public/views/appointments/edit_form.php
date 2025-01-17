<?php require(__DIR__ . '/../partials/header.php'); ?>

<div class="container mx-auto mt-8">
    <h1 class="text-2xl font-bold mb-4">Edit Appointment #<?= htmlspecialchars($appointment['id']); ?></h1>

    <form 
        action="/appointments/edit/<?= htmlspecialchars($appointment['id']); ?>" 
        method="POST" 
        class="max-w-md bg-white p-6 rounded shadow"
    >
        <!-- USER DROPDOWN -->
        <div class="mb-4">
            <label class="block mb-1 font-semibold" for="user_id">Select User</label>
            <select name="user_id" id="user_id" class="w-full border border-gray-300 rounded px-3 py-2" required>
                <option value="" disabled>-- Select User --</option>
                <?php foreach ($allUsers as $u): ?>
                    <option value="<?= htmlspecialchars($u['id']); ?>"
                        <?php if ($u['id'] == $appointment['user_id']) echo 'selected'; ?>>
                        <?= htmlspecialchars($u['username']); ?> (ID: <?= $u['id']; ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- HAIRDRESSER DROPDOWN -->
        <div class="mb-4">
            <label class="block mb-1 font-semibold" for="hairdresser_id">Select Hairdresser</label>
            <select name="hairdresser_id" id="hairdresser_id" class="w-full border border-gray-300 rounded px-3 py-2" required>
                <option value="" disabled>-- Select Hairdresser --</option>
                <?php foreach ($allHairdressers as $h): ?>
                    <option value="<?= htmlspecialchars($h['id']); ?>"
                        <?php if ($h['id'] == $appointment['hairdresser_id']) echo 'selected'; ?>>
                        <?= htmlspecialchars($h['name']); ?> (ID: <?= $h['id']; ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- DATE -->
        <div class="mb-4">
            <label class="block mb-1 font-semibold" for="appointment_date">Appointment Date</label>
            <input
                type="date"
                name="appointment_date"
                id="appointment_date"
                value="<?= htmlspecialchars($appointment['appointment_date']); ?>"
                class="w-full border border-gray-300 rounded px-3 py-2"
                required
            >
        </div>

        <!-- TIME -->
        <div class="mb-4">
            <label class="block mb-1 font-semibold" for="appointment_time">Appointment Time</label>
            <input
                type="time"
                name="appointment_time"
                id="appointment_time"
                value="<?= htmlspecialchars($appointment['appointment_time']); ?>"
                class="w-full border border-gray-300 rounded px-3 py-2"
                required
            >
        </div>

        <!-- STATUS -->
        <div class="mb-4">
            <label class="block mb-1 font-semibold" for="status">Status</label>
            <select name="status" id="status" class="w-full border border-gray-300 rounded px-3 py-2">
                <option value="upcoming"  <?php if ($appointment['status'] === 'upcoming')  echo 'selected'; ?>>Upcoming</option>
                <option value="completed" <?php if ($appointment['status'] === 'completed') echo 'selected'; ?>>Completed</option>
                <option value="canceled"  <?php if ($appointment['status'] === 'canceled')  echo 'selected'; ?>>Canceled</option>
            </select>
        </div>

        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            Update Appointment
        </button>
    </form>
</div>

<?php require(__DIR__ . '/../partials/footer.php'); ?>
