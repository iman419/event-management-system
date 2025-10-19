
$(function () {
 
  var app = $.spapp({
    defaultView: "#view_home",
    templateDir: "./",
    pageNotFound: "error_404"
  });

  
  const EVENTS_JSON = './assets/mock/events.json';

  
  app.route({
    view: "view_home",
    onReady: function () {
      if ($('#eventsChart').length) {
        Highcharts.chart('eventsChart', {
          title: { text: 'Events per Category' },
          xAxis: { categories: ['Music', 'Tech', 'Sports', 'Arts', 'Other'] },
          series: [{ name: 'Events', data: [5, 3, 2, 4, 1] }]
        });
      }
      if ($('#ticketsChart').length) {
        Highcharts.chart('ticketsChart', {
          title: { text: 'Tickets Sold (Last 6 Months)' },
          xAxis: { categories: ['May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'] },
          series: [{ name: 'Tickets', data: [120, 180, 240, 200, 260, 300] }]
        });
      }
    }
  });

  
  app.route({
    view: "view_events",
    onReady: async function () {
      const $table = $('#eventsTable');
      const $tbody = $('#eventsTable tbody');

      
      $tbody.html(
        `<tr><td colspan="5" class="text-center text-muted">Loading events…</td></tr>`
      );

      
      if ($.fn.DataTable && $.fn.DataTable.isDataTable($table)) {
        $table.DataTable().destroy();
      }

      try {
        const res = await fetch(EVENTS_JSON, { cache: 'no-cache' });
        if (!res.ok) throw new Error('Failed to load events.json');
        const data = await res.json();

        
        $tbody.html(
          data.map(e => `
            <tr>
              <td>${e.title}</td>
              <td>${e.category}</td>
              <td>${e.venue}</td>
              <td>${new Date(e.starts_at).toLocaleString()}</td>
              <td>
                <a class="btn btn-sm btn-outline-secondary" href="#view_event?id=${e.id}">View</a>
              </td>
            </tr>
          `).join('')
        );

        
        if ($.fn.DataTable) new DataTable('#eventsTable');
      } catch (err) {
        console.error(err);
        $tbody.html(
          `<tr><td colspan="5" class="text-center text-danger">Could not load events. Check assets/mock/events.json</td></tr>`
        );
      }
    }
  });

 
  app.route({
    view: "view_event",
    onReady: async function () {
      const params = new URLSearchParams((location.hash.split('?')[1] || ''));
      const id = params.get('id');

      const $body = $('#eventBody');
      if (!id) {
        $body.html(`<div class="alert alert-warning">Missing event ID. <a href="#view_events">Back to events</a></div>`);
        return;
      }

      $body.html(`<div class="text-muted">Loading event…</div>`);

      try {
        const res = await fetch(EVENTS_JSON, { cache: 'no-cache' });
        if (!res.ok) throw new Error('Failed to load events.json');
        const data = await res.json();

        const ev = data.find(e => String(e.id) === String(id));
        if (!ev) {
          $body.html(`<div class="alert alert-warning">Event not found. <a href="#view_events">Back to events</a></div>`);
          return;
        }

        $('#evTitle').text(ev.title);
        $('#evMeta').text(`${ev.category} • ${ev.venue} • ${new Date(ev.starts_at).toLocaleString()}`);
        $('#evDesc').text(ev.description);
      } catch (err) {
        console.error(err);
        $body.html(`<div class="alert alert-danger">Error loading event details.</div>`);
      }
    }
  });

 
  app.route({ view: "view_venues" });
  app.route({ view: "view_tickets" });
  app.route({ view: "view_login" });
  app.route({ view: "view_register" });
  app.route({ view: "view_profile" });
  app.route({ view: "view_admin" });

  
  app.run();
});
