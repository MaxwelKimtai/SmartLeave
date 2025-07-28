
document.addEventListener('DOMContentLoaded', function () {
  var calendarEl = document.getElementById('calendarView');
  var calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    height: 500,
    themeSystem: 'standard',
    events: 'fetch-leaves.php', // You should return events from DB
    eventClick: function(info) {
      alert('Leave: ' + info.event.title);
    }
  });
  calendar.render();

  // Overview Chart
  const overviewCtx = document.getElementById('overviewChart').getContext('2d');
  new Chart(overviewCtx, {
    type: 'bar',
    data: {
      labels: ['Sick Leave', 'Annual Leave', 'Casual Leave'],
      datasets: [{
        label: 'Days Taken',
        data: [5, 10, 3],
        backgroundColor: ['#a1887f', '#ffccbc', '#8d6e63']
      }]
    },
    options: {
      responsive: true,
      plugins: { legend: { position: 'top' } }
    }
  });

  // Leave Chart
  const leaveCtx = document.getElementById('leaveChart').getContext('2d');
  new Chart(leaveCtx, {
    type: 'doughnut',
    data: {
      labels: ['Used', 'Remaining'],
      datasets: [{
        data: [12, 18],
        backgroundColor: ['#bcaaa4', '#d7ccc8']
      }]
    },
    options: {
      responsive: true
    }
  });
});
