document.addEventListener('DOMContentLoaded', () => {
  const editBtn = document.getElementById('editProfileBtn');
  const saveBtn = document.getElementById('saveProfileBtn');
  const form = document.getElementById('profileForm');
  const inputs = form.querySelectorAll('input');
  let isEditing = false;

  editBtn.addEventListener('click', () => {
    isEditing = !isEditing;

    inputs.forEach(input => {
      if (input.name !== 'username') {
        input.readOnly = !isEditing;
      }
    });

    if (isEditing) {
      editBtn.textContent = 'Cancel';
      editBtn.classList.replace('btn-secondary', 'btn-danger');
      saveBtn.classList.remove('d-none');
    } else {
      editBtn.textContent = 'Edit Profile';
      editBtn.classList.replace('btn-danger', 'btn-secondary');
      saveBtn.classList.add('d-none');
      form.reset();
    }
  });
});

document.addEventListener('DOMContentLoaded', () => {
  const profileForm = document.getElementById('profileForm');

  profileForm.addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(profileForm);

    fetch(profileForm.action, {
      method: 'POST',
      body: formData
    })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          // Show success notification
          Swal.fire({
            icon: 'success',
            title: 'Profile Updated',
            text: 'Your profile has been updated successfully!',
            showConfirmButton: true,
            confirmButtonText: 'OK'
          }).then(() => {
            // Redirect after user clicks OK
            window.location.href = 'customer-dashboard.php';
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Update Failed',
            text: data.message || 'Something went wrong',
          });
        }
      })
      .catch(err => {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Could not update profile',
        });
      });
  });
});
