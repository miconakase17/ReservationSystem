function updateUserCount() {
  fetch('process/UserCountProcess.php')
    .then(res => res.json())
    .then(data => {
      document.querySelector('.card-title').textContent = data.totalUsers;
    })
    .catch(err => console.error('Error fetching user count:', err));
}

// Initial load
updateUserCount();

// Optional: refresh every 10 seconds
setInterval(updateUserCount, 10000);
