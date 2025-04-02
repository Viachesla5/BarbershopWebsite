<?php 
require_once(__DIR__ . '/../../../views/partials/header.php');
$security = Security::getInstance();
?>

<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold mb-6 text-white">Edit Appointment</h1>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="bg-red-900 border border-red-700 text-red-100 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline"><?= htmlspecialchars($_SESSION['error']); ?></span>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <form method="POST" class="dark-card p-6">
            <input type="hidden" name="csrf_token" value="<?= $security->generateCSRFToken(); ?>">

            <div class="mb-4">
                <label class="block text-gray-300 text-sm font-bold mb-2" for="user_id">
                    User
                </label>
                <select name="user_id" id="user_id" class="form-input" required>
                    <option value="">Select a user</option>
                    <?php foreach ($users as $user): ?>
                        <option value="<?= htmlspecialchars($user['id']); ?>" <?= $user['id'] == $appointment['user_id'] ? 'selected' : ''; ?>>
                            <?= htmlspecialchars($user['username']); ?> (<?= htmlspecialchars($user['email']); ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-300 text-sm font-bold mb-2" for="hairdresser_id">
                    Hairdresser
                </label>
                <select name="hairdresser_id" id="hairdresser_id" class="form-input" required>
                    <option value="">Select a hairdresser</option>
                    <?php foreach ($hairdressers as $hairdresser): ?>
                        <option value="<?= htmlspecialchars($hairdresser['id']); ?>" <?= $hairdresser['id'] == $appointment['hairdresser_id'] ? 'selected' : ''; ?>>
                            <?= htmlspecialchars($hairdresser['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-300 text-sm font-bold mb-2" for="appointment_date">
                    Appointment Date
                </label>
                <input type="date" name="appointment_date" id="appointment_date" 
                       value="<?= htmlspecialchars($appointment['appointment_date']); ?>"
                       class="form-input"
                       required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-300 text-sm font-bold mb-2" for="appointment_time">
                    Appointment Time
                </label>
                <input type="time" name="appointment_time" id="appointment_time" 
                       value="<?= htmlspecialchars($appointment['appointment_time']); ?>"
                       class="form-input"
                       required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-300 text-sm font-bold mb-2" for="status">
                    Status
                </label>
                <select name="status" id="status" class="form-input" required>
                    <option value="upcoming" <?= $appointment['status'] === 'upcoming' ? 'selected' : ''; ?>>Upcoming</option>
                    <option value="completed" <?= $appointment['status'] === 'completed' ? 'selected' : ''; ?>>Completed</option>
                    <option value="cancelled" <?= $appointment['status'] === 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                </select>
            </div>

            <div class="flex items-center justify-between">
                <a href="/admin/appointments" class="bg-gray-700 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition-colors duration-200">
                    Cancel
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition-colors duration-200">
                    Update Appointment
                </button>
            </div>
        </form>
    </div>
</div>

<?php require_once(__DIR__ . '/../../../views/partials/footer.php'); ?> 