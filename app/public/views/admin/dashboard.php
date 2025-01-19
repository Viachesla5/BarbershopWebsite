<?php require(__DIR__ . '/../partials/header.php'); ?>

<div class="container mx-auto mt-8">
    <h1 class="text-2xl font-bold mb-4">Admin Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <a href="/admin/users" class="block bg-blue-200 p-4 rounded shadow hover:bg-blue-300">
            Manage Users
        </a>
        <a href="/admin/hairdressers" class="block bg-green-200 p-4 rounded shadow hover:bg-green-300">
            Manage Hairdressers
        </a>
        <a href="/admin/appointments" class="block bg-yellow-200 p-4 rounded shadow hover:bg-yellow-300">
            Manage Appointments
        </a>
    </div>
</div>

<?php require(__DIR__ . '/../partials/footer.php'); ?>
