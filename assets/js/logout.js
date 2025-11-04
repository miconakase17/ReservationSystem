document.addEventListener('DOMContentLoaded', () => {
    const logoutBtn = document.getElementById('logoutBtn');

    logoutBtn.addEventListener('click', (e) => {
        e.preventDefault(); // prevent default link behavior

        Swal.fire({
            title: 'Are you sure?',
            text: "Do you really want to log out?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, log me out',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // First, destroy the session via AJAX or redirect
                fetch('process/logout.php')
                    .then(() => {
                        // Show success message
                        Swal.fire({
                            title: 'Logged Out!',
                            text: 'You have successfully logged out.',
                            icon: 'success',
                            timer: 1500,
                            showConfirmButton: false,
                            willClose: () => {
                                window.location.href = 'index.html'; // main page
                            }
                        });
                    })
                    .catch(err => console.error(err));
            }
        });
    });
});
