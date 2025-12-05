$(document).ready(function () {

    /* ---------------------------------------------------------
       APPROVE RESERVATION
    --------------------------------------------------------- */
    $(document).on("click", ".approve-reservation", function () {
        const id = $(this).data("id");
        Swal.fire({
            title: "Approve this reservation?",
            text: "The customer will see this as approved.",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#28a745",
            cancelButtonColor: "#6c757d",
            confirmButtonText: "Yes, approve"
        }).then((result) => {
            if (result.isConfirmed) {
                $.post("process/ApproveReservationProcess.php", { id: id }, function (response) {
                    if (response.success) {
                        Swal.fire("Approved!", response.message, "success");
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        Swal.fire("Error", response.message, "error");
                    }
                }, "json");
            }
        });
    });

    /* ---------------------------------------------------------
       CANCEL RESERVATION
    --------------------------------------------------------- */
    $(document).on("click", ".cancel-reservation", function () {
        const id = $(this).data("id");
        Swal.fire({
            title: "Cancel this reservation?",
            text: "This action cannot be undone.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#6c757d",
            confirmButtonText: "Yes, cancel it"
        }).then((result) => {
            if (result.isConfirmed) {
                $.post("process/CancelReservationProcess.php", { id: id }, function (response) {
                    if (response.success) {
                        Swal.fire("Cancelled!", response.message, "success");
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        Swal.fire("Error", response.message, "error");
                    }
                }, "json");
            }
        });
    });

    /* ---------------------------------------------------------
       COMPLETE RESERVATION (Manual Completion)
    --------------------------------------------------------- */
    $(document).on("click", ".complete-reservation", function () {
        const id = $(this).data("id");
        Swal.fire({
            title: "Mark as Completed?",
            text: "This reservation will be marked as completed.",
            icon: "info",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#6c757d",
            confirmButtonText: "Yes, complete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.post("process/CompleteReservationProcess.php", { id: id }, function (response) {
                    if (response.success) {
                        Swal.fire("Completed!", response.message, "success")
                            .then(() => location.reload());
                    } else {
                        Swal.fire("Error", response.message, "error");
                    }
                }, "json");
            }
        });
    });

    /* ---------------------------------------------------------
       OPEN SEND EMAIL MODAL
    --------------------------------------------------------- */
    $('.send-email-btn').on('click', function () {
        const email = $(this).data('email');
        const customer = $(this).data('customer');
        $('#recipientEmail').val(email);
        $('#recipientEmailDisplay').val(`${customer} <${email}>`);
        $('#emailMessage').val('');
        $('#sendEmailModal').modal('show');
    });

});
