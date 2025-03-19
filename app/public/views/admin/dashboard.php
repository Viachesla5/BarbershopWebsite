<?php require(__DIR__ . '/../partials/header.php'); ?>

<div class="container mx-auto mt-8 p-6">
    <h1 class="text-2xl font-bold mb-6 text-white">Admin Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Users Card -->
        <div class="bg-dark-100 rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-semibold mb-4 text-white">Users</h2>
            <div class="flex justify-between items-center">
                <p class="text-3xl font-bold text-blue-400"><?= $total_users ?></p>
                <a href="/admin/users" class="text-blue-400 hover:text-blue-500">View All →</a>
            </div>
        </div>

        <!-- Hairdressers Card -->
        <div class="bg-dark-100 rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-semibold mb-4 text-white">Hairdressers</h2>
            <div class="flex justify-between items-center">
                <p class="text-3xl font-bold text-purple-400"><?= $total_hairdressers ?></p>
                <a href="/admin/hairdressers" class="text-purple-400 hover:text-purple-500">View All →</a>
            </div>
        </div>

        <!-- Appointments Card -->
        <div class="bg-dark-100 rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-semibold mb-4 text-white">Appointments</h2>
            <div class="flex justify-between items-center">
                <p class="text-3xl font-bold text-green-400"><?= $total_appointments ?></p>
                <a href="/admin/appointments" class="text-green-400 hover:text-green-500">View All →</a>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="mt-8">
        <h2 class="text-xl font-semibold mb-4 text-white">Recent Activity</h2>
        <div class="bg-dark-100 rounded-lg shadow-lg overflow-hidden">
            <table class="min-w-full">
                <thead class="bg-dark-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-200">Date</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-200">Activity</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-200">User</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-200">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-dark-50">
                    <?php foreach ($recent_activities as $activity) : ?>
                        <tr class="hover:bg-dark-200 transition duration-150">
                            <td class="px-6 py-4 text-sm text-gray-300"><?= $activity['date'] ?></td>
                            <td class="px-6 py-4 text-sm text-gray-300"><?= $activity['description'] ?></td>
                            <td class="px-6 py-4 text-sm text-gray-300"><?= $activity['user'] ?></td>
                            <td class="px-6 py-4 text-sm">
                                <span class="<?= getStatusColor($activity['status']) ?> px-2 py-1 rounded-full text-xs">
                                    <?= $activity['status'] ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require(__DIR__ . '/../partials/footer.php'); ?>

<?php
function getStatusColor($status) {
    return match(strtolower($status)) {
        'completed' => 'bg-green-500 text-white',
        'pending' => 'bg-yellow-500 text-white',
        'cancelled' => 'bg-red-500 text-white',
        default => 'bg-gray-500 text-white'
    };
}
?>
