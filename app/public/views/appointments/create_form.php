<?php require(__DIR__ . '/../partials/header.php'); ?>

<div class="container mx-auto mt-8 p-6">
    <h1 class="text-2xl font-bold mb-6 text-white">Create a New Appointment</h1>

    <form action="/appointments/create" method="POST" class="max-w-md bg-dark-100 p-6 rounded shadow-lg border border-dark-50">
        
        <!-- USER DROPDOWN -->
        <div class="mb-4">
            <label class="block mb-1 font-semibold text-gray-200" for="user_id">Select User</label>
            <select name="user_id" id="user_id" class="w-full bg-dark-200 text-white border border-dark-50 rounded px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500" required>
                <option value="" disabled selected class="bg-dark-200">-- Select User --</option>
                <?php foreach ($allUsers as $u): ?>
                    <option value="<?= htmlspecialchars($u['id']); ?>" class="bg-dark-200">
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
                <option value="" disabled selected class="bg-dark-200">-- Select Hairdresser --</option>
                <?php foreach ($allHairdressers as $h): ?>
                    <option value="<?= htmlspecialchars($h['id']); ?>" class="bg-dark-200">
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
                class="w-full bg-dark-200 text-white border border-dark-50 rounded px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                required
            >
            <p class="text-red-400 text-sm mt-1">Required</p>
        </div>

        <!-- Optionally add a default 'status' hidden field or let it default in the DB -->
        <!-- <input type="hidden" name="status" value="upcoming" /> -->

        <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition duration-200">
            Create Appointment
        </button>
    </form>
</div>

<?php require(__DIR__ . '/../partials/footer.php'); ?>