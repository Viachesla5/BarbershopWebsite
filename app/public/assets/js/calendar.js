document.addEventListener('DOMContentLoaded', function() {
  let calendarEl = document.getElementById('calendar');
  let hairdresserSelect = document.getElementById('selectHairdresser');

  let calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    selectable: true,
    events: '/appointments/events', // getCalendarEvents endpoint

    // 1) CREATE appointment flow:
    select: function(info) {
      let chosenDate = info.startStr; // e.g. "2025-01-20"
      let chosenTime = prompt("Enter time in HH:MM (24h)", "07:00");
      if (!chosenTime) {
        calendar.unselect();
        return;
      }
      let hairdresserId = hairdresserSelect.value;

      // POST to createFromCalendar
      fetch('/appointments/createFromCalendar', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
          date: chosenDate,
          time: chosenTime,
          hairdresser_id: hairdresserId
        })
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          alert("Appointment Created!");
          calendar.refetchEvents(); // reload events
        } else {
          alert("Error: " + data.message);
        }
      })
      .catch(err => {
        console.error(err);
        alert("An error occurred while creating the appointment.");
      });

      calendar.unselect();
    },

    // 2) DELETE appointment flow:
    eventClick: function(info) {
      // 'info' has event details, e.g. info.event.id
      let eventId = info.event.id;

      // Prompt user
      let confirmDelete = confirm(`Delete appointment #${eventId}?`);
      if (!confirmDelete) {
        return;
      }

      // If confirmed, send a request to delete
      fetch('/appointments/deleteFromCalendar', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({
          id: eventId
        })
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          alert("Appointment Deleted!");
          info.event.remove();

        } else {
          alert("Error: " + data.message);
        }
      })
      .catch(err => {
        console.error(err);
        alert("An error occurred while deleting the appointment.");
      });
    }
  });

  calendar.render();
});
