<?php require(__DIR__ . '/../partials/header.php'); ?>

<link href="https://cdn.jsdelivr.net/npm/fullcalendar@latest/main.min.css" rel="stylesheet" />

<div class="min-h-screen bg-dark-200">
    <div class="container mx-auto px-4 py-12">
        <!-- Header Section -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-white mb-4">Appointment Calendar</h1>
            <p class="text-gray-300 max-w-2xl mx-auto">
                Select a hairdresser and choose your preferred time slot. 
                We'll make sure you get the perfect appointment.
            </p>
        </div>

        <!-- Hairdresser selection -->
        <div class="max-w-md mx-auto mb-8">
            <label class="block mb-2 font-semibold text-gray-200" for="selectHairdresser">Select Your Stylist</label>
            <select id="selectHairdresser"
                    class="w-full bg-dark-100 text-white border border-dark-50 rounded-lg px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 transition-all duration-200">
                <option value="" disabled selected>-- Choose a Hairdresser --</option>
                <?php
                require_once(__DIR__ . "/../../models/HairdresserModel.php");
                $hairdresserModel = new HairdresserModel();
                $hairdressers = $hairdresserModel->getAll();

                foreach ($hairdressers as $hairdresser) {
                    echo "<option value=\"" . htmlspecialchars($hairdresser['id']) . "\">"
                        . htmlspecialchars($hairdresser['name'])
                        . "</option>";
                }
                ?>
            </select>
        </div>

        <!-- Calendar Container -->
        <div class="bg-dark-100 rounded-lg shadow-xl p-6">
            <div id="calendar" class="fc-theme-dark"></div>
        </div>
    </div>
</div>

<!-- Custom CSS for FullCalendar -->
<style>
    .fc-theme-dark {
        --fc-border-color: #374151;
        --fc-button-bg-color: #1f2937;
        --fc-button-border-color: #374151;
        --fc-button-text-color: #fff;
        --fc-button-hover-bg-color: #374151;
        --fc-button-hover-border-color: #4b5563;
        --fc-button-active-bg-color: #3b82f6;
        --fc-button-active-border-color: #3b82f6;
        --fc-event-bg-color: #3b82f6;
        --fc-event-border-color: #3b82f6;
        --fc-event-text-color: #fff;
        --fc-today-bg-color: rgba(59, 130, 246, 0.1);
    }

    .fc {
        color: #fff;
    }

    .fc .fc-toolbar-title {
        color: #fff;
    }

    .fc .fc-col-header-cell {
        background-color: #1f2937;
        color: #fff;
    }

    .fc .fc-daygrid-day {
        background-color: #1f2937;
    }

    .fc .fc-day-today {
        background-color: rgba(59, 130, 246, 0.1) !important;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@latest/main.min.js"></script>
<script src="/assets/js/calendar.js"></script>

<?php require(__DIR__ . '/../partials/footer.php'); ?>