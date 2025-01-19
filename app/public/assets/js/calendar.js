document.addEventListener('DOMContentLoaded', function() {
    // Grab the element where the calendar will be rendered
    let calendarEl = document.getElementById('calendar');
    
    // Reference to the hairdresser select
    let hairdresserSelect = document.getElementById('selectHairdresser');

    // Initialize FullCalendar
    let calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      // or 'timeGridWeek' if you want a week/time view
      events: '/appointments/events', // This calls our getCalendarEvents()
      selectable: true,              // Allows user to select cells
      selectMirror: true,
      select: function(info) {
        // info.startStr might look like "2025-02-10"
        // For a dayGrid, time might be midnight by default
        // If you want a time-based view, consider timeGridWeek/timeGridDay
  
        // Let's prompt the user for a time or assume a default:
        let chosenTime = prompt("Enter time in HH:MM format (24h)", "14:00");
        if (!chosenTime) {
          calendar.unselect();
          return;
        }
        console.log(chosenTime);
        // Gather selected data
        let chosenDate = info.startStr; // e.g. "2025-02-10"

        console.log(chosenDate);
        let hairdresserId = hairdresserSelect.value;
  
        // Send to server via fetch
        fetch('/appointments/createFromCalendar', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          },
          body: new URLSearchParams({
            date: chosenDate,
            time: chosenTime,
            hairdresser_id: hairdresserId
          })
        })
        .then((response) => {
            // Check if the response is valid JSON
            if (!response.ok) {
              throw new Error(`HTTP Error: ${response.status}`);
            }
            return response.json();
          })
        .then(data => {
          if (data.success) {
            alert("Appointment Created!");
            // Reload events on the calendar
            calendar.refetchEvents();
          } else {
            alert("Error: " + data.message);
          }
        })
        .catch(err => {
          console.error(err);
          alert("An error occurred while creating the appointment.");
        });
        
        // unselect after handling
        calendar.unselect();
      }
    });
  
    // Render the calendar
    calendar.render();
  });  