<?php require(__DIR__ . '/../partials/header.php'); ?>

<div class="container mx-auto mt-8 p-6">
    <h1 class="text-2xl font-bold mb-6 text-white">All Appointments</h1>

    <!-- Conditionally show "Create Appointment" if not a hairdresser -->
    <?php if (empty($_SESSION['hairdresser_id'])): ?>
        <div class="mb-6">
            <a href="/appointments/create" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition duration-200">
                Create Appointment
            </a>
        </div>
    <?php endif; ?>

    <?php if (!empty($appointments)): ?>
        <div class="overflow-x-auto rounded-lg border border-dark-50">
            <table class="min-w-full bg-dark-100">
                <thead>
                    <tr class="bg-dark-200 border-b border-dark-50">
                        <th class="py-3 px-4 text-gray-200">ID</th>
                        <th class="py-3 px-4 text-gray-200">User</th>
                        <th class="py-3 px-4 text-gray-200">Hairdresser</th>
                        <th class="py-3 px-4 text-gray-200">Date</th>
                        <th class="py-3 px-4 text-gray-200">Time</th>
                        <th class="py-3 px-4 text-gray-200">Status</th>
                        <th class="py-3 px-4 text-gray-200">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($appointments as $apt): ?>
                        <tr class="border-b border-dark-50 hover:bg-dark-200 transition-colors duration-150">
                            <td class="py-3 px-4 text-center text-gray-300">
                                <?= htmlspecialchars($apt['id']); ?>
                            </td>

                            <!-- Show user name, not user_id -->
                            <td class="py-3 px-4 text-center text-gray-300">
                                <?= htmlspecialchars($apt['user_name']); ?>
                            </td>

                            <!-- Show hairdresser name, not hairdresser_id -->
                            <td class="py-3 px-4 text-center text-gray-300">
                                <?= htmlspecialchars($apt['hairdresser_name']); ?>
                            </td>

                            <td class="py-3 px-4 text-center text-gray-300">
                                <?= htmlspecialchars($apt['appointment_date']); ?>
                            </td>
                            <td class="py-3 px-4 text-center text-gray-300">
                                <?= htmlspecialchars($apt['appointment_time']); ?>
                            </td>
                            <td class="py-3 px-4 text-center">
                                <span class="<?= getStatusColor($apt['status']); ?> px-2 py-1 rounded text-sm">
                                    <?= htmlspecialchars($apt['status']); ?>
                                </span>
                            </td>

                            <!-- Actions -->
                            <td class="py-3 px-4 text-center">
                                <?php if (empty($_SESSION['hairdresser_id'])): ?>
                                    <a href="/appointments/edit/<?= $apt['id']; ?>"
                                       class="text-blue-400 hover:text-blue-300 transition-colors duration-150 mr-3">
                                       Edit
                                    </a>
                                    <a href="/appointments/delete/<?= $apt['id']; ?>"
                                       class="text-red-400 hover:text-red-300 transition-colors duration-150"
                                       onclick="return confirm('Are you sure you want to delete this appointment?');">
                                       Delete
                                    </a>
                                <?php else: ?>
                                    <span class="text-gray-500">No actions</span>
                                <?php endif; ?>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p class="text-gray-300">No appointments found.</p>
    <?php endif; ?>
</div>

<?php
// Helper function to get status color
function getStatusColor($status) {
    switch (strtolower($status)) {
        case 'pending':
            return 'bg-yellow-900/20 text-yellow-400';
        case 'confirmed':
            return 'bg-green-900/20 text-green-400';
        case 'cancelled':
            return 'bg-red-900/20 text-red-400';
        case 'completed':
            return 'bg-blue-900/20 text-blue-400';
        default:
            return 'bg-gray-900/20 text-gray-400';
    }
}
?>

<?php require(__DIR__ . '/../partials/footer.php'); ?>