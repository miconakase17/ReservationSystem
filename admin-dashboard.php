<?php
session_start();
require_once __DIR__ . '/includes/ReservationData.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>Admin Dashboard | Kevin's Express Studio</title>
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
  <script>
    const isAdmin = <?php echo $isAdmin ? 'true' : 'false'; ?>;
  </script>


  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- CSS Files -->
  <link rel="stylesheet" href="admin/assets/css/bootstrap.min.css" />
  <link rel="stylesheet" href="admin/assets/css/plugins.min.css" />
  <link rel="stylesheet" href="admin/assets/css/kaiadmin.min.css" />
  <link rel="stylesheet" href="assets/css/calendar.css">
  <link rel="stylesheet" href="assets/css/table.css">


</head>

<body>

  <!-- CALENDAR MODAL -->
  <div class="modal fade" id="calendarModal" tabindex="-1" aria-labelledby="calendarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <!-- Calendar Body -->
      <div class="modal-body">
        <div class="modal-content w-100 p-0 rounded bg-light">
          <div class="calendar-container p-4">
            <div class="calendar">

              <!-- Header Row -->
              <div class="d-flex justify-content-between align-items-center mb-3">

                <!-- Left side: month dropdown + year -->
                <div class="gap-2 ms-0">
                  <select id="monthSelect" class="form-select form-select-sm w-auto" style="margin-left: 0;">
                    <option value="0">January</option>
                    <option value="1">February</option>
                    <option value="2">March</option>
                    <option value="3">April</option>
                    <option value="4">May</option>
                    <option value="5">June</option>
                    <option value="6">July</option>
                    <option value="7">August</option>
                    <option value="8">September</option>
                    <option value="9">October</option>
                    <option value="10">November</option>
                    <option value="11">December</option>
                  </select>
                </div>

                <div class="d-flex align-items-center gap-2">
                  <!-- Left arrow -->
                  <span class="bi bi-chevron-left fs-5" id="prevYear" style="cursor:pointFer;"></span>

                  <!-- Dynamic year label -->
                  <span class="year fw-bold fs-5 mb-0" id="yearLabel"></span>

                  <!-- Right arrow -->
                  <span class="bi bi-chevron-right fs-5" id="nextYear" style="cursor:pointer;"></span>
                </div>


                <!-- Right side: navigation arrows -->
                <div class="me-0">
                  <span class="bi bi-chevron-left me-3" id="prev" style="cursor:pointer;"></span>
                  <span class="bi bi-chevron-right" id="next" style="cursor:pointer;"></span>
                </div>
              </div>
            </div>

            <div class="table-responsive">
              <table class="table text-center align-middle" id="week-calendar">
                <thead>
                  <tr>
                    <th style="width: 100px;">Time</th>
                    <th>Sun</th>
                    <th>Mon</th>
                    <th>Tue</th>
                    <th>Wed</th>
                    <th>Thu</th>
                    <th>Fri</th>
                    <th>Sat</th>
                  </tr>
                  <tr id="weekDatesRow">
                    <th></th>
                    <td id="sun"></td>
                    <td id="mon"></td>
                    <td id="tue"></td>
                    <td id="wed"></td>
                    <td id="thu"></td>
                    <td id="fri"></td>
                    <td id="sat"></td>
                  </tr>
                </thead>
                <tbody id="calendar-body"></tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--END CALENDAR MODAL-->

  <!--NEW USER MODAL-->
  <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="process/AddUserProcess.php" method="post" class="row g-3 p-3">
          <!-- First Name -->
          <div class="col-sm-4">
            <input type="text" name="firstname" class="form-control" placeholder="First Name*" required>
          </div>
          <!-- Last Name -->
          <div class="col-sm-4">
            <input type="text" name="lastname" class="form-control" placeholder="Last Name*" required>
          </div>
          <!-- Middle Name -->
          <div class="col-sm-4">
            <input type="text" name="middlename" class="form-control" placeholder="Middle Name">
          </div>
          <!-- Username -->
          <div class="col-12">
            <input type="text" name="username" class="form-control" placeholder="Username*" required>
          </div>
          <!-- Phone Number -->
          <div class="col-12">
            <input type="text" name="phonenumber" class="form-control" placeholder="Phone Number*" required>
          </div>
          <!-- Email -->
          <div class="col-12">
            <input type="email" name="email" class="form-control" placeholder="Email*" required>
          </div>
          <!-- Password -->
          <div class="col-12">
            <input type="password" name="password" class="form-control" placeholder="Password*" required>
          </div>
          <!-- Confirm Password -->
          <div class="col-12">
            <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password*"
              required>
          </div>
          <!-- Role Selection -->
          <div class="col-12">
            <select name="roleID" class="form-select" required>
              <option value="1">Admin</option>
            </select>
          </div>
          <!-- Submit Button -->
          <div class="col-12 text-center mt-3">
            <button type="submit" class="btn btn-primary">Add User</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!--END NEW USER MODAL-->

  <div class="wrapper">
    <!-- Sidebar -->
    <div class="sidebar" data-background-color="dark">
      <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
          <a class="logo">
            <img src="assets/img/logo.png" alt="navbar brand" class="navbar-brand" height="55" />
          </a>
          <div class="nav-toggle">
            <button class="btn btn-toggle toggle-sidebar">
              <i class="gg-menu-right"></i>
            </button>
            <button class="btn btn-toggle sidenav-toggler">
              <i class="gg-menu-left"></i>
            </button>
          </div>
          <button class="topbar-toggler more">
            <i class="gg-more-vertical-alt"></i>
          </button>
        </div>
        <!-- End Logo Header -->
      </div>
      <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
          <ul class="nav nav-secondary">
            <li class="nav-item active">
              <a href="#dashboard">
                <i class="fas fa-home"></i>
                <p>Admin Dashboard</p>
              </a>
            </li>
            <li class="nav-section">
              <span class="sidebar-mini-icon">
                <i class="fa fa-ellipsis-h"></i>
              </span>
              <h4 class="text-section">Components</h4>
            </li>
            <li class="nav-item">
              <a href="manage-user.php" href="#manageUsers">
                <i class="fas fa-users"></i>
                <p>Manage Users</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="manage-reservation.php">
                <i class="fas fa-calendar"></i>
                <p>Manage Reservations</p>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <!-- End Sidebar -->

    <div class="main-panel">
      <div class="main-header">
        <!-- Navbar Header -->
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
        <!-- End Navbar -->
      </div>

      <div class="container">
        <div class="page-inner">
          <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
              <h3 class="fw-bold mb-3">Admin Dashboard</h3>
              <h6 class="op-7 mb-2">Kevin's Express Studio</h6>
            </div>
            <div class="ms-md-auto py-2 py-md-0">
              <a class="btn btn-primary btn-view-calendar btn-round me-2" data-bs-target="#calendarModal"
                data-bs-toggle="modal">View Calendar</a>
              <a href="#" class="btn btn-primary btn-round" data-bs-toggle="modal" data-bs-target="#addUserModal">Add
                User</a>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6 col-md-12">
              <div class="card card-stats card-round">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col-icon">
                      <div class="icon-big text-center icon-primary bubble-shadow-small">
                        <i class="fas fa-users"></i>
                      </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                      <div class="numbers">
                        <p class="card-category">Users</p>
                        <h4 class="card-title">
                          <?php echo number_format($totalUsers); ?>
                        </h4>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="card card-round">
                  <div class="card-body">
                    <div class="card-head-row card-tools-still-right">
                      <div class="card-title">New Users</div>
                      <div class="card-tools">
                        <div class="dropdown">
                        </div>
                      </div>
                    </div>
                    <div class="card-list py-4" id="latestUsersList">
                      <!-- Latest users will be loaded here dynamically -->
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <footer class="footer">
        <div class="container-fluid d-flex justify-content-between">
          <nav class="pull-left">
            <ul class="nav">
              <li class="nav-item">
                <a class="nav-link" href="http://www.themekita.com">
                  ThemeKita
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#"> Help </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#"> Licenses </a>
              </li>
            </ul>
          </nav>
          <div class="copyright">
            2024, made with <i class="fa fa-heart heart text-danger"></i> by
            <a href="http://www.themekita.com">ThemeKita</a>
          </div>
          <div>
            Distributed by
            <a target="_blank" href="https://themewagon.com/">ThemeWagon</a>.
          </div>
        </div>
      </footer>
    </div>
  </div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>

  <script>
    window.studioPricings = <?php echo json_encode($studioPricings); ?>;
    window.recordingPricings = <?php echo json_encode($recordingPricings); ?>;
  </script>

  <!--   Core JS Files   -->
  <script src="admin/assets/js/core/jquery-3.7.1.min.js"></script>
  <script src="admin/assets/js/core/popper.min.js"></script>
  <script src="admin/assets/js/core/bootstrap.min.js"></script>
  <script src="assets/js/calendar.js"></script>
  <script src="assets/js/fetch_user.js"></script>
  <script src="assets/js/user_count.js"></script>
  <script src="assets/js/studio_rental.js"></script>
  <script src="assets/js/recording.js"></script>
  <script src="assets/js/drum_lesson.js"></script>
  <script src="assets/js/main.js"></script>
  <script src="assets/js/reservation.js"></script>
  <script src="assets/js/logout.js"></script>

  <!-- jQuery Scrollbar -->
  <script src="admin/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

  <!-- Chart JS -->
  <script src="admin/assets/js/plugin/chart.js/chart.min.js"></script>

  <!-- jQuery Sparkline -->
  <script src="admin/assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>

  <!-- Chart Circle -->
  <script src="admin/assets/js/plugin/chart-circle/circles.min.js"></script>

  <!-- Datatables -->
  <script src="admin/assets/js/plugin/datatables/datatables.min.js"></script>

  <!-- Bootstrap Notify -->
  <script src="admin/assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>

  <!-- jQuery Vector Maps -->
  <script src="admin/assets/js/plugin/jsvectormap/jsvectormap.min.js"></script>
  <script src="admin/assets/js/plugin/jsvectormap/world.js"></script>

  <!-- Sweet Alert -->
  <script src="admin/assets/js/plugin/sweetalert/sweetalert.min.js"></script>

  <!-- Kaiadmin JS -->
  <script src="admin/assets/js/kaiadmin.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    $("#lineChart").sparkline([102, 109, 120, 99, 110, 105, 115], {
      type: "line",
      height: "70",
      width: "100%",
      lineWidth: "2",
      lineColor: "#177dff",
      fillColor: "rgba(23, 125, 255, 0.14)",
    });

    $("#lineChart2").sparkline([99, 125, 122, 105, 110, 124, 115], {
      type: "line",
      height: "70",
      width: "100%",
      lineWidth: "2",
      lineColor: "#f3545d",
      fillColor: "rgba(243, 84, 93, .14)",
    });

    $("#lineChart3").sparkline([105, 103, 123, 100, 95, 105, 115], {
      type: "line",
      height: "70",
      width: "100%",
      lineWidth: "2",
      lineColor: "#ffa534",
      fillColor: "rgba(255, 165, 52, .14)",
    });
  </script>

</body>

</html>