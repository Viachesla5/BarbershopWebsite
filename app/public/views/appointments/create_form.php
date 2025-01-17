<?php require(__DIR__ . '/../partials/header.php'); ?>

<div class="container mx-auto mt-8">
    <h1 class="text-2xl font-bold mb-4">Create a New Appointment</h1>

    <form action="/appointments/create" method="POST" class="max-w-md bg-white p-6 rounded shadow">
        
        <!-- USER DROPDOWN -->
        <div class="mb-4">
            <label class="block mb-1 font-semibold" for="user_id">Select User</label>
            <select name="user_id" id="user_id" class="w-full border border-gray-300 rounded px-3 py-2" required>
                <option value="" disabled selected>-- Select User --</option>
                <?php foreach ($allUsers as $u): ?>
                    <option value="<?= htmlspecialchars($u['id']); ?>">
                        <?= htmlspecialchars($u['username']); ?> (ID: <?= $u['id']; ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- HAIRDRESSER DROPDOWN -->
        <div class="mb-4">
            <label class="block mb-1 font-semibold" for="hairdresser_id">Select Hairdresser</label>
            <select name="hairdresser_id" id="hairdresser_id" class="w-full border border-gray-300 rounded px-3 py-2" required>
                <option value="" disabled selected>-- Select Hairdresser --</option>
                <?php foreach ($allHairdressers as $h): ?>
                    <option value="<?= htmlspecialchars($h['id']); ?>">
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
                class="w-full border border-gray-300 rounded px-3 py-2"
                required
            >
        </div>

        <!-- Optionally add a default 'status' hidden field or let it default in the DB -->
        <!-- <input type="hidden" name="status" value="upcoming" /> -->

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Create Appointment
        </button>
    </form>
</div>

<?php require(__DIR__ . '/../partials/footer.php'); ?>