<?php require(__DIR__ . '/../partials/header.php'); ?>

<div class="container mx-auto mt-8">
    <h1 class="text-2xl font-bold mb-4">All Appointments</h1>

    <!-- Conditionally show "Create Appointment" if not a hairdresser -->
    <?php if (empty($_SESSION['hairdresser_id'])): ?>
        <div class="mb-4">
            <a href="/appointments/create" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Create Appointment
            </a>
        </div>
    <?php endif; ?>

    <?php if (!empty($appointments)): ?>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="py-2 px-4 border-b">ID</th>
                        <th class="py-2 px-4 border-b">User</th>
                        <th class="py-2 px-4 border-b">Hairdresser</th>
                        <th class="py-2 px-4 border-b">Date</th>
                        <th class="py-2 px-4 border-b">Time</th>
                        <th class="py-2 px-4 border-b">Status</th>
                        <th class="py-2 px-4 border-b">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($appointments as $apt): ?>
                        <tr>
                            <td class="py-2 px-4 border-b text-center">
                                <?= htmlspecialchars($apt['id']); ?>
                            </td>

                            <!-- Show user name, not user_id -->
                            <td class="py-2 px-4 border-b text-center">
                                <?= htmlspecialchars($apt['user_name']); ?>
                            </td>

                            <!-- Show hairdresser name, not hairdresser_id -->
                            <td class="py-2 px-4 border-b text-center">
                                <?= htmlspecialchars($apt['hairdresser_name']); ?>
                            </td>

                            <td class="py-2 px-4 border-b text-center">
                                <?= htmlspecialchars($apt['appointment_date']); ?>
                            </td>
                            <td class="py-2 px-4 border-b text-center">
                                <?= htmlspecialchars($apt['appointment_time']); ?>
                            </td>
                            <td class="py-2 px-4 border-b text-center">
                                <?= htmlspecialchars($apt['status']); ?>
                            </td>

                            <!-- Actions -->
                            <td class="py-2 px-4 border-b text-center">
                                <?php if (empty($_SESSION['hairdresser_id'])): ?>
                                    <a href="/appointments/edit/<?= $apt['id']; ?>"
                                       class="text-blue-500 hover:underline mr-2">
                                       Edit
                                    </a>
                                    <a href="/appointments/delete/<?= $apt['id']; ?>"
                                       class="text-red-500 hover:underline"
                                       onclick="return confirm('Are you sure you want to delete this appointment?');">
                                       Delete
                                    </a>
                                <?php else: ?>
                                    <span class="text-gray-400">No actions</span>
                                <?php endif; ?>
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