<?php
session_start();
require_once __DIR__ . '/process/FetchAllReservationsProcess.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Manage Reservations - Admin | Kevin's Express Studio</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />

    <link href="assets/img/headlogo.png" rel="icon">

    <!-- Fonts and icons -->
    <script src="admin/assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
        WebFont.load({
            google: { families: ["Public Sans:300,400,500,600,700"] },
            custom: {
                families: [
                    "Font Awesome 5 Solid",
                    "Font Awesome 5 Regular",
                    "Font Awesome 5 Brands",
                    "simple-line-icons",
                ],
                urls: ["admin/assets/css/fonts.min.css"],
            },
            active: function () {
                sessionStorage.fonts = true;
            },
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="admin/assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="admin/assets/css/plugins.min.css" />
    <link rel="stylesheet" href="admin/assets/css/kaiadmin.min.css" />

    <!-- Datatables -->
    <link rel="stylesheet" href="admin/assets/js/plugin/datatables/datatables.min.css" />

    <!-- Your Custom styles -->
    <link rel="stylesheet" href="assets/css/table.css">
</head>

<body>

    <?php
    if (isset($_SESSION['email_status'])):
        $status = $_SESSION['email_status'];
        ?>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                icon: '<?= $status['success'] ? 'success' : 'error' ?>',
                title: '<?= addslashes($status['message']) ?>',
                timer: 2000,
                showConfirmButton: false
            });
        </script>
        <?php
        unset($_SESSION['email_status']);
    endif;
    ?>



    <!-- Edit Reservation Modal -->
    <div class="modal fade" id="editReservationModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editReservationForm">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Reservation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <input type="hidden" id="editReservationID" name="reservationID">

                        <div class="mb-3">
                            <label class="form-label">Service Type</label>
                            <select name="serviceType" id="editServiceType" class="form-select">
                                <option value="Studio Rental">Studio Rental</option>
                                <option value="Recording">Recording</option>
                                <option value="Drum Lesson">Drum Lesson</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Date</label>
                            <input type="date" class="form-control" id="editDate" name="date" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Start Time</label>
                            <input type="time" class="form-control" id="editStartTime" name="startTime" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">End Time</label>
                            <input type="time" class="form-control" id="editEndTime" name="endTime" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" id="editStatus" name="status">
                                <option value="Pending">Pending</option>
                                <option value="Approved">Approved</option>
                                <option value="Completed">Completed</option>
                                <option value="Cancelled">Cancelled</option>
                            </select>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="sendEmailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="sendEmailForm" action="process/SendEmailProcess.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title">Send Email</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="recipientEmail" name="email">
                        <div class="mb-3">
                            <label class="form-label">To</label>
                            <input type="text" class="form-control" id="recipientEmailDisplay" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Message</label>
                            <textarea class="form-control" id="emailMessage" name="message" rows="5"
                                required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Send Email</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <div class="wrapper">
        <!-- Sidebar -->
        <div class="sidebar" data-background-color="dark">
            <div class="sidebar-logo">
                <div class="logo-header" data-background-color="dark">
                    <a href="admin-dashboard.php" class="logo">
                        <img src="assets/img/logo.png" alt="navbar brand" class="navbar-brand" height="55" />
                    </a>
                </div>
            </div>

            <div class="sidebar-wrapper scrollbar scrollbar-inner">
                <div class="sidebar-content">
                    <ul class="nav nav-secondary">
                        <li class="nav-item">
                            <a href="admin-dashboard.php">
                                <i class="fas fa-home"></i>
                                <p>Admin Dashboard</p>
                            </a>
                        </li>

                        <li class="nav-section">
                            <span class="sidebar-mini-icon"><i class="fa fa-ellipsis-h"></i></span>
                            <h4 class="text-section">Components</h4>
                        </li>

                        <li class="nav-item">
                            <a href="manage-user.php">
                                <i class="fas fa-users"></i>
                                <p>Manage Users</p>
                            </a>
                        </li>

                        <li class="nav-item active">
                            <a href="manage-reservation.php">
                                <i class="fas fa-calendar"></i>
                                <p>Manage Reservations</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Main Panel -->
        <div class="main-panel">
            <div class="main-header">
                <nav class="navbar navbar-header navbar-expand-lg border-bottom">
                    <div class="container-fluid">
                        <span class="navbar-brand fw-bold">Kevin's Express Music Studio</span>
                        <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                            <li class="nav-item">
                                <a href="#" id="logoutBtn" class="btn btn-primary btn-sm">Log Out</a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>

            <div class="container">
                <div class="page-inner">

                    <div class="page-header">
                        <h3 class="fw-bold mb-3">Manage Reservations</h3>
                        <ul class="breadcrumbs mb-3">
                            <li class="nav-home"><a href="admin-dashboard.php"><i class="icon-home"></i></a></li>
                            <li class="separator"><i class="icon-arrow-right"></i></li>
                            <li class="nav-item">Manage Reservations</li>
                        </ul>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <p class="card-category">Total Reservations</p>
                            <h4 class="card-title"><?= number_format($totalReservations) ?></h4>
                        </div>

                        <div class="table-responsive">
                            <table id="reservation-table" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Customer</th>
                                        <th>Service</th>
                                        <th>Date</th>
                                        <th>Start</th>
                                        <th>End</th>
                                        <th>Amount Paid</th>
                                        <th>Reference No.</th>
                                        <th>Created At</th>
                                        <th>Receipt</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                        <th>Email</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php foreach ($reservations as $r): ?>
                                        <tr>

                                            <td><?= htmlspecialchars($r['customer']) ?></td>
                                            <td><?= htmlspecialchars($r['serviceType']) ?></td>
                                            <td><?= htmlspecialchars($r['date']) ?></td>
                                            <td><?= htmlspecialchars($r['startTime']) ?></td>
                                            <td><?= htmlspecialchars($r['endTime']) ?></td>
                                            <td><?= number_format($r['amountPaid'] / 2, 2) ?></td>
                                            <td><?= htmlspecialchars($r['referenceNumber']) ?></td>
                                            <td><?= date('M d, Y H:i', strtotime($r['createdAt'])) ?></td>

                                            <td>
                                                <?php if (!empty($r['receipts'])): ?>
                                                    <?php foreach ($r['receipts'] as $receipt): ?>
                                                        <a href="uploads/<?= htmlspecialchars($receipt['fileName']) ?>"
                                                            target="_blank" class="btn btn-primary btn-sm mb-1">
                                                            View
                                                        </a>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    No Receipt
                                                <?php endif; ?>
                                            </td>


                                            <td><?= htmlspecialchars($r['status']) ?></td>

                                            <td>
                                                <?php if ($r['status'] === 'Pending'): ?>
                                                    <button class="btn btn-success btn-sm approve-reservation"
                                                        data-id="<?= $r['id'] ?>">
                                                        Approve
                                                    </button>
                                                    <button class="btn btn-danger btn-sm cancel-reservation"
                                                        data-id="<?= $r['id'] ?>">
                                                        Cancel
                                                    </button>
                                                <?php elseif ($r['status'] === 'Confirmed'): ?>
                                                    <button class="btn btn-complete btn-sm complete-reservation"
                                                        data-id="<?= $r['id'] ?>">
                                                        Complete
                                                    </button>
                                                    <button class="btn btn-danger btn-sm cancel-reservation"
                                                        data-id="<?= $r['id'] ?>">
                                                        Cancel
                                                    </button>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <button class="btn btn-info btn-sm send-email-btn"
                                                    data-email="<?= htmlspecialchars($r['email']) ?>"
                                                    data-customer="<?= htmlspecialchars($r['customer']) ?>">
                                                    <i class="fas fa-envelope"></i>
                                                </button>
                                            </td>

                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>

                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <footer class="footer">
            <div class="container-fluid d-flex justify-content-between">
                <div>© 2024 Kaiadmin</div>
            </div>
        </footer>

    </div>

    <!-- Core JS -->
    <script src="admin/assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="admin/assets/js/core/bootstrap.min.js"></script>
    <script src="admin/assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
    <script src="assets/js/logout.js"></script>
    <!-- Datatables -->
    <script src="admin/assets/js/plugin/datatables/datatables.min.js"></script>

    <script>
        $(document).ready(function () {
            $("#reservation-table").DataTable();
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="assets/js/manage_reservation.js"></script>



</body>

</html>