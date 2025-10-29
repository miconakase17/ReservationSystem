document.addEventListener('DOMContentLoaded', function() {
    console.log("Logout JS loaded"); // <--- test
    const logoutLink = document.getElementById('logout-link');
    if (logoutLink) {
        console.log("Logout link found");
        logoutLink.addEventListener('click', function(event) {
            event.preventDefault();
            alert("Test logout message"); // <--- test message
        });
    } else {
        console.error("Logout link not found!");
    }
});
