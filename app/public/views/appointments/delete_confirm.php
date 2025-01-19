<?php require(__DIR__ . '/../partials/header.php'); ?>

<div class="container mx-auto mt-8">
    <h1 class="text-2xl font-bold mb-4">Delete Appointment #<?= htmlspecialchars($appointment['id'] ?? '', ENT_QUOTES, 'UTF-8'); ?></h1>

    <p>Are you sure you want to delete this appointment?</p>
    <p><strong>Date:</strong> <?= htmlspecialchars($appointment['appointment_date'] ?? '', ENT_QUOTES, 'UTF-8'); ?>
       <strong>Time:</strong> <?= htmlspecialchars($appointment['appointment_time'] ?? '', ENT_QUOTES, 'UTF-8'); ?>
    </p>
    <p><strong>Status:</strong> <?= htmlspecialchars($appointment['status'] ?? '', ENT_QUOTES, 'UTF-8'); ?></p>

    <form action="/appointments/deleteConfirm/<?= htmlspecialchars($appointment['id'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" method="POST" class="mt-4">
        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
            Yes, Delete
        </button>
        <a href="/appointments" class="bg-gray-300 text-black px-4 py-2 rounded hover:bg-gray-400 ml-2">
            Cancel
        </a>
    </form>
</div>

<?php require(__DIR__ . '/../partials/footer.php'); ?>
