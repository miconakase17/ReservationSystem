document.addEventListener("DOMContentLoaded", function () {
  fetch('process/FetchLatestUserProcess.php')
    .then(response => response.json())
    .then(res => {
      if (res.status === 'success') {
        const container = document.getElementById('latestUsersList');
        container.innerHTML = res.data.map(user => {
          const firstName = user.firstName || 'N/A';
          const lastName = user.lastName || '';
          const initials = `${firstName[0]}${lastName[0]}`.toUpperCase();
          const roleClass = user.roleID == 1 ? 'bg-danger' : 'bg-success'; // badge color

          return `
          <div class="item-list">
            <div class="avatar">
              <span class="avatar-title rounded-circle border border-white ${roleClass}">
                ${initials}
              </span>
            </div>
            <div class="info-user ms-3">
              <div class="username">${firstName} ${lastName}</div>
              <div class="status">
                ${user.roleID == 1 ? 'Admin' : 'Customer'}
              </div>
            </div>
            <button class="btn btn-icon btn-link op-8 me-1">
              <i class="far fa-envelope"></i>
            </button>
            <button class="btn btn-icon btn-link btn-danger op-8">
              <i class="fas fa-ban"></i>
            </button>
          </div>
          `;
        }).join('');
      } else {
        console.error('Error fetching users:', res.message);
      }
    })
    .catch(err => console.error('Fetch error:', err));
});
