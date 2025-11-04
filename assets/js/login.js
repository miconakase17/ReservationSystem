document.addEventListener("DOMContentLoaded", () => {
    const loginMessageElement = document.getElementById("loginMessage");

    if (loginMessageElement) {
        const message = loginMessageElement.dataset.message;
        const type = loginMessageElement.dataset.type || "error"; // default to error

        if (message) {
            Swal.fire({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true,
                icon: type, // 'success' or 'error'
                title: message,
                background: type === "success" ? "#f0fff0" : "#fce5ec",
                color: type === "success" ? "#228B22" : "#333"
            });
        }
    }
});
