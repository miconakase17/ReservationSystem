<?php
session_start();
require_once __DIR__ . '/includes/ReservationData.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Welcome! | Kevin's Express Music Studio</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap"
    rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">
  <link href="assets/css/reservation.css" rel="stylesheet">
  <link href="assets/css/calendar.css" rel="stylesheet">

</head>

<body class="customer-dashboard-page">

  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

      <a href="customer-dashboard.php" class="logo d-flex align-items-center me-auto">
        <h1 class="sitename">Kevin's Express Studio</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="customer-dashboard.php">Home</a></li>
          <li><a href="#view-reservation">View Reservation</a></li>
          <li><a href="#" data-bs-target="#calendarModal" data-bs-toggle="modal">View Calendar</a></li>
          <li><a href="#" data-bs-target="#profileModal" data-bs-toggle="modal">Profile</a></li>
          <li><a href="#" id="logoutBtn">Log Out</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <a class="cta-btn" data-bs-target="#reservationForm" data-bs-toggle="modal">Reserve Now!</a>

    </div>
  </header>

  <main class="main">

    <!-- Modal -->
    <div class="modal fade" id="reservationForm" tabindex="-1" aria-labelledby="reservationFormTitle"
      aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">

          <!-- Header -->
          <div class="modal-header">
            <h5 class="modal-title" id="reservationFormTitle">Kevin's Express Music Studio</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <!-- Body -->
          <div class="modal-body">
            <form action="process/ReservationProcess.php" method="post" class="reservation-form"
              enctype="multipart/form-data">

              <div class="container section-title text-center">
                <h3>New Reservation</h3>
              </div>

              <div class="row gy-4">

                <div class="col-6">
                  <input type="text" name="firstname" class="form-control"
                    value="<?php echo htmlspecialchars($_SESSION['user']['firstName'] ?? ''); ?>" readonly>
                </div>

                <div class="col-6">
                  <input type="text" name="lastname" class="form-control"
                    value="<?php echo htmlspecialchars($_SESSION['user']['lastName'] ?? ''); ?>" readonly>
                </div>

                <div class="row gy-4 align-items-start">
                  <!-- LEFT SIDE -->
                  <div class="col-md-6">
                    <!-- Date -->
                    <div class="mb-3">
                      <label for="date" class="form-label fw-bold">Select Date:</label>
                      <input type="date" id="date" name="date" class="form-control">
                    </div>

                    <!-- Start Time -->
                    <div class="mb-3">
                      <label for="startTime" class="form-label fw-bold">Start Time:</label>
                      <input type="time" id="startTime" name="startTime" class="form-control">
                    </div>

                    <!-- End Time -->
                    <div class="mb-3">
                      <label for="endTime" class="form-label fw-bold">End Time:</label>
                      <input type="time" id="endTime" name="endTime" class="form-control">
                      <small id="endTimeNote" class="text-muted" style="display:none;">
                        For Drum Lesson, the session must be 2 hours.
                      </small>
                    </div>

                    <!-- Upload Receipt -->
                    <div class="mb-3">
                      <label class="form-label fw-bold">Upload Receipt:</label>
                      <input type="file" id="receipt" name="receipt" accept="image/*" class="form-control">
                    </div>
                    <div class="mb-3">
                      <img id="rental-image-preview" src="" alt="Preview"
                        style="max-width:100%; height:auto; display:none; border:1px solid #ddd; padding:6px;" />
                    </div>
                  </div>

                  <!-- RIGHT SIDE -->
                  <div class="col-md-6 text-center">
                    <label class="form-label fw-bold mb-2">GCash (Down Payment):</label>
                    <div class="mb-2">
                      <img src="assets/img/QR_Payment.png" alt="GCash QR"
                        style="max-width:220px; height:auto; border:1px solid #ddd; padding:6px;" />
                    </div>
                    <p class="small text-muted mb-3">
                      Scan this QR code with GCash to pay half of the total payment.
                    </p>

                    <!-- Reference No -->
                    <div class="mt-3">
                      <label class="form-label fw-bold">Reference No.</label>
                      <input type="text" name="referenceNumber" id="referenceNumber" class="form-control w-75 mx-auto"
                        required>
                    </div>
                  </div>
                </div>



                <div class="col-6">
                  <select name="serviceID" id="service" class="form-select" required>
                    <option value="" disabled selected>Select Service</option>
                    <option value="1">Studio Rental</option>
                    <option value="2">Recording</option>
                    <option value="3">Drum Lesson</option>
                  </select>
                </div>

                <!-- Studio Rental Fields -->
                <div id="studio-fields" class="row gy-4" style="display: none;">
                  <div class="col-12">
                    <div class="row gy-3 align-items-start">

                      <!-- Band Name and Total Hours (Left Side) -->
                      <div class="col-md-6">
                        <label class="form-label fw-bold">Band Name:</label>
                        <input type="text" name="bandName" class="form-control mb-3" placeholder="Enter Band Name">

                        <label class="form-label fw-bold">Total Hours:</label>
                        <input type="text" id="totalHours" name="totalHours" class="form-control" readonly>
                      </div>

                      <!-- Additionals (Right Side) -->
                      <div class="col-md-6">
                        <label class="form-label fw-bold">Additionals:</label>
                        <div class="d-flex flex-wrap">
                          <?php if ($additionals && $additionals->num_rows > 0): ?>
                            <?php while ($row = $additionals->fetch_assoc()): ?>
                              <div class="form-check me-3 mb-2">
                                <input class="form-check-input additional-checkbox" type="checkbox"
                                  id="additional-<?php echo $row['addID']; ?>" name="additionals[]"
                                  value="<?php echo $row['addID']; ?>" data-price="<?php echo $row['price']; ?>">
                                <label class="form-check-label" for="additional-<?php echo $row['addID']; ?>">
                                  <?php echo htmlspecialchars($row['addName']); ?>
                                  (₱<?php echo number_format($row['price'], 2); ?>)
                                </label>
                              </div>
                            <?php endwhile; ?>
                          <?php else: ?>
                            <p class="text-muted mb-0">No additionals available.</p>
                          <?php endif; ?>
                        </div>
                      </div>

                    </div>
                  </div>
                </div>

                <!-- Recording Fields -->
                <div id="recording-fields" class="row gy-4" style="display: none;">
                  <div class="col-12">
                    <label class="form-label fw-bold">Recording Mode:</label><br>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="recordingMode" id="multitrack"
                        value="MultiTrack" required>
                      <label class="form-check-label" for="multitrack">Multi Track</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="recordingMode" id="livetrack" value="LiveTrack"
                        required>
                      <label class="form-check-label" for="livetrack">Live Track</label>
                    </div>
                  </div>

                  <div class="col-12">
                    <label class="form-label fw-bold">Option:</label><br>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="checkbox" name="mix" id="mix" value="Mix">
                      <label class="form-check-label" for="mix">Mix and Master</label>
                    </div>
                  </div>
                </div>

                <!-- DRUM LESSON FIELD -->
                <div id="drumlesson-fields" class="row gy-4" style="display: none;">
                  <!-- Weekly Sessions -->
                  <div class="row gy-2 mt-3">
                    <div class="col-12">
                      <label class="form-label fw-bold">Weekly Sessions (12 weeks):</label>
                      <ul id="drumlesson-sessions-list" style="list-style:none; padding-left:0;"></ul>
                      <div id="drumlesson-sessions-inputs"></div>
                      <small class="text-muted">
                        Selected date/time will repeat weekly on the same weekday and hour for 12 weeks.
                        These sessions are added to the form on submit.
                      </small>
                    </div>
                  </div>
                </div>
                <div class="row gy-3">

                  <div class="col-sm-6">
                    <label class="form-label fw-bold">Total Amount (₱):</label>
                    <input type="text" id="totalCost" name="totalCost" class="form-control mb-2" readonly>
                  </div>

                  <div class="col-sm-6">
                    <label class="form-label fw-bold">Down Payment (₱):</label>
                    <input type="text" name="downPayment" id="downPayment" class="form-control" readonly>
                  </div>
                </div>


                <div class=" col-12 text-center">
                  <button type="submit" class="btn btn-primary mt-3">Submit Reservation</button>
                </div>

              </div>
            </form>
          </div>

        </div>
      </div>
    </div>

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
                    <span class="bi bi-chevron-left fs-5" id="prevYear" style="cursor:pointer;"></span>

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
    <!-- End Calendar Modal -->

    <!-- Page Title -->
    <div class="page-title dark-background" data-aos="fade"
      style="background-image: url(assets/img/page-title-bg.webp);">
      <div class="container position-relative">
        <h1>Welcome, <?php
        echo htmlspecialchars($_SESSION['user']['firstName'] ?? 'Customer');
        ?>!</h1>
        <p>Kevin's Express Music Studio</p>
        <nav class="breadcrumbs">
          <ol>
            <li class="current"><a>Home</a></li>
            <li><a href="#" data-bs-target="#reservationForm" data-bs-toggle="modal">Reserve Now!</a></li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

    <!-- View Reservation Section -->
    <section id="view-reservation" class="customer-dashboard section">
      <div class="container" data-aos="fade-up">

        <div class="row gy-4">
          <!-- Main Content -->
          <div class="col-lg-10 mx-auto" data-aos="fade-up" data-aos-delay="200">
            <h3 class="mb-4"><i class="bi bi-calendar-event"></i> My Reservations</h3>

            <!-- Reservation List -->
            <div class="table-responsive">
              <table class="table table-striped table-hover align-middle text-center" id="user-reservations">
                <thead class="table-dark">
                  <tr>
                    <th>Service</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Price (₱)</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td colspan="5">Loading your reservations...</td>
                  </tr>
                </tbody>
              </table>
            </div>

          </div>
        </div>

      </div>
    </section>
    <!-- End View Reservation Section -->

    <!-- Profile Modal -->
    <div class="modal fade" id="profileModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <!-- Header -->
          <div class="modal-header">
            <h5 class="modal-title"><i class="bi bi-person-circle"></i> My Profile</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>

          <!-- Body -->
          <div class="modal-body">
            <form id="profileForm" action="process/UpdateProfileProcess.php" method="POST">
              <div class="row g-3">
                <div class="col-md-6">
                  <label class="form-label fw-bold">Username</label>
                  <input type="text" name="username" class="form-control"
                    value="<?php echo htmlspecialchars($_SESSION['user']['username'] ?? ''); ?>" readonly>
                </div>

                <div class="col-md-6">
                  <label class="form-label fw-bold">Email</label>
                  <input type="email" name="email" class="form-control"
                    value="<?php echo htmlspecialchars($_SESSION['user']['email'] ?? ''); ?>" readonly>
                </div>

                <div class="col-md-6">
                  <label class="form-label fw-bold">First Name</label>
                  <input type="text" name="firstName" class="form-control"
                    value="<?php echo htmlspecialchars($_SESSION['user']['firstName'] ?? ''); ?>" readonly>
                </div>

                <div class="col-md-6">
                  <label class="form-label fw-bold">Last Name</label>
                  <input type="text" name="lastName" class="form-control"
                    value="<?php echo htmlspecialchars($_SESSION['user']['lastName'] ?? ''); ?>" readonly>
                </div>

                <div class="col-md-6">
                  <label class="form-label fw-bold">Phone</label>
                  <input type="text" name="phoneNumber" class="form-control"
                    value="<?php echo htmlspecialchars($_SESSION['user']['phoneNumber'] ?? ''); ?>" readonly>
                </div>
              </div>

              <!-- Buttons -->
              <div class="mt-4 text-end">
                <button type="button" id="editProfileBtn" class="btn btn-secondary">Edit Profile</button>
                <button type="submit" id="saveProfileBtn" class="btn btn-primary d-none">Save Changes</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>


  </main>

  <footer id="footer" class="footer dark-background">

    <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-lg-4 col-md-6 footer-about">
          <a href="index.html" class="logo d-flex align-items-center">
            <span class="sitename">Kevin's Express Studio</span>
          </a>
          <div class="footer-contact pt-3">
            <p>89 A. Bonifacio St.,</p>
            <p>Brgy. Canlalay, City of Biñan, Laguna, PH</p>
            <p class="mt-3"><strong>Phone:</strong> <span>+63 926 937 8332</span></p>
            <p><strong>Email:</strong> <span>alonte003@gmail.com</span></p>
          </div>
          <div class="social-links d-flex mt-4">
            <a href=""><i class="bi bi-facebook"></i></a>
            <a href=""><i class="bi bi-youtube"></i></a>
            <a href=""><i class="bi bi-instagram"></i></a>
          </div>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Useful Links</h4>
          <ul>
            <li><i class="bi bi-chevron-right"></i> <a href="#">Home</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="#">About us</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="#">Services</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="#">Bands</a></li>
          </ul>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Our Services</h4>
          <ul>
            <li><i class="bi bi-chevron-right"></i> <a href="#">Recording</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="#">Studio Rental</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="#">Drum Lesson</a></li>
          </ul>
        </div>
      </div>
    </div>

    <div class="container copyright text-center mt-4">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">Kevin's Express Studio</strong> <span>All Rights
          Reserved</span> <strong>2025</strong></p>
    </div>
  </footer>
  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
      class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <script>
    const studioPricings = <?php echo json_encode($studioPricings, JSON_HEX_TAG); ?>;
    window.recordingPricings = <?php echo json_encode($recordingPricings, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;
  </script>

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
    // Pricing rules injected from server (service_pricings for Studio Rental)
    window.studioPricings = <?php echo json_encode($studioPricings, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?> || [];
  </script>
  <script>
    // Show reservation confirmation modal when ?reserved=1 is present
    (function () {
      try {
        const params = new URLSearchParams(window.location.search);
        if (params.get('reserved') === '1') {
          // show bootstrap modal success
          var reservedModal = new bootstrap.Modal(document.getElementById('reservedModal'));
          reservedModal.show();
          params.delete('reserved');
          const newUrl = window.location.pathname + (params.toString() ? '?' + params.toString() : '');
          window.history.replaceState({}, document.title, newUrl);
        } else if (params.get('reserved') === '0') {
          var errModal = new bootstrap.Modal(document.getElementById('reservedErrorModal'));
          errModal.show();
          params.delete('reserved');
          const newUrl2 = window.location.pathname + (params.toString() ? '?' + params.toString() : '');
          window.history.replaceState({}, document.title, newUrl2);
        }
      } catch (err) {
        console.error(err);
      }
    })();
  </script>
  <script src="assets/js/reservation.js"></script>
  <script src="assets/js/studio_rental.js"></script>
  <script src="assets/js/recording.js"></script>
  <script src="assets/js/drum_lesson.js"></script>
  <script src="assets/js/fetch_user_reservation.js"></script>
  <script src="assets/js/calendar.js"></script>
  <script src="assets/js/update_profile.js"></script>
  <script src="assets/js/logout.js"></script>
  <script src="assets/js/main.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</body>

</html>