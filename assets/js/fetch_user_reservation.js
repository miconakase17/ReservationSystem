document.addEventListener('DOMContentLoaded', () => {
  const tableBody = document.querySelector('#user-reservations tbody');

  loadUserReservations(); // NEW FUNCTION

  function loadUserReservations() {
    fetch('process/FetchUserReservationProcess.php')
      .then(res => res.json())
      .then(data => {
        tableBody.innerHTML = ''; // clear placeholder

        if (!data.success || data.data.length === 0) {
          tableBody.innerHTML = `
            <tr>
              <td colspan="6" class="text-center">
                <i class="bi bi-calendar-x display-6 d-block mb-2"></i>
                You have no reservations yet.<br>
                <a href="#" data-bs-target="#reservationForm" data-bs-toggle="modal" 
                   class="btn btn-primary btn-sm mt-2">
                  Reserve Now!
                </a>
              </td>
            </tr>`;
          return;
        }

        data.data.forEach(item => {
          const date = new Date(item.date);
          const start = item.startTime ? formatTime(item.startTime) : '';
          const end = item.endTime ? formatTime(item.endTime) : '';

          // Show cancel only for pending/confirmed
          let cancelBtn = '';
          const statusLower = (item.statusName || '').toLowerCase();

          if (statusLower === 'pending' || statusLower === 'confirmed') {
            cancelBtn = `
              <button class="btn btn-danger btn-sm cancel-reservation"
                data-id="${item.reservationID}">
                Cancel
              </button>
            `;
          } else {
            cancelBtn = `<span class="text-muted">---</span>`;
          }

          const row = `
            <tr>
              <td>${escapeHtml(item.serviceName || 'Service')}</td>
              <td>${date.toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' })}</td>
              <td>${start} - ${end}</td>
              <td>₱${Number(item.totalCost).toLocaleString()}</td>
              <td>
                <span class="badge rounded-pill ${getStatusClass(item.statusName)}">
                  ${escapeHtml(item.statusName || '')}
                </span>
              </td>
              <td>${cancelBtn}</td>
            </tr>`;
          tableBody.insertAdjacentHTML('beforeend', row);
        });
      })
      .catch(err => {
        console.error(err);
        tableBody.innerHTML =
          `<tr><td colspan="6" class="text-danger text-center">Failed to load reservations.</td></tr>`;
      });
  }

  // CANCEL RESERVATION
  document.addEventListener('click', function (e) {
    if (e.target.classList.contains('cancel-reservation')) {
      const reservationID = e.target.getAttribute('data-id');

      Swal.fire({
        title: "Cancel this reservation?",
        text: "This action cannot be undone.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes, cancel it"
      }).then((result) => {
        if (result.isConfirmed) {

          fetch('process/CancelUserReservationProcess.php', {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `reservationID=${reservationID}`
          })
          .then(res => res.json())
          .then(response => {
            if (response.success) {
              Swal.fire("Cancelled!", response.message, "success");
              loadUserReservations(); // refresh table
            } else {
              Swal.fire("Error", response.message, "error");
            }
          })
          .catch(() => Swal.fire("Error", "Something went wrong.", "error"));
        }
      });

    }
  });

  function formatTime(timeStr) {
    const [h, m] = timeStr.split(':');
    const d = new Date();
    d.setHours(h, m);
    return d.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
  }

  function escapeHtml(text) {
    return text ? text.replace(/[&<>"']/g, c => ({
      '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'
    }[c])) : '';
  }

  function getStatusClass(status) {
    switch ((status || '').toLowerCase()) {
      case 'confirmed': return 'bg-success text-light';
      case 'pending': return 'bg-warning text-dark';
      case 'cancelled': return 'bg-danger text-light';
      case 'cancelled by customer': return 'bg-danger text-light';
      default: return 'bg-secondary text-light';
    }
  }
});
