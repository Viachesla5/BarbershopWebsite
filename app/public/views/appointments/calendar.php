<?php require(__DIR__ . '/../partials/header.php'); ?>

<link href="https://cdn.jsdelivr.net/npm/fullcalendar@latest/main.min.css" rel="stylesheet" />

<div class="container mx-auto mt-8">
    <h1 class="text-2xl font-bold mb-4">Appointments Calendar</h1>

    <!-- Hairdresser selection -->
    <div class="mb-4">
        <label class="block mb-1 font-semibold" for="selectHairdresser">Select Hairdresser</label>
        <select id="selectHairdresser"
                class="border border-gray-300 rounded px-3 py-2">
            <option value="" disabled selected>-- Select Hairdresser --</option>
            <?php
            // Dynamically load hairdressers from the database
            require_once(__DIR__ . "/../../models/HairdresserModel.php");
            $hairdresserModel = new HairdresserModel();
            $hairdressers = $hairdresserModel->getAll(); // Assumes getAll() returns an array of hairdressers

            foreach ($hairdressers as $hairdresser) {
                echo "<option value=\"" . htmlspecialchars($hairdresser['id']) . "\">"
                    . htmlspecialchars($hairdresser['name']) . " (ID: " . htmlspecialchars($hairdresser['id']) . ")"
                    . "</option>";
            }
            ?>
        </select>
    </div>

    <div id="calendar"></div>
</div>

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@latest/main.min.js"></script>
<!-- Include our custom JS for the calendar -->
<script src="/assets/js/calendar.js"></script>

<?php require(__DIR__ . '/../partials/footer.php'); ?>