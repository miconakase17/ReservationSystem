<?php
session_start();
// Load reservation-related data (additionals + pricing) from an include
require_once __DIR__ . '/includes/reservation-data.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Reservation | Kevin's Express Studio</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">
  <link href="assets/css/reservation.css" rel="stylesheet">   
</head>

<body class="reservation-dashboard-page">

  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

      <a href="customer-dashboard.php" class="logo d-flex align-items-center me-auto">
        <h1 class="sitename">Kevin's Express Studio</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="customer-dashboard.php">Home</a></li>
          <li><a href="#about">View Reservation</a></li>
          <li><a href="#services">Profile</a></li>
          <li><a href="reservation-dashboard.html">Log Out</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <a class="cta-btn" href="">Reserve Now!</a>

    </div>
  </header>

    <section id="reservation-section" class="reservation-section dark-background align-items-center justify-content-center min-vh-100">
      <video src="assets/video/mainvideo.mp4" autoplay muted loop playsinline></video>

      <div class="container">
        <div class="row justify-content-center"> 
          <div class="col-lg-6">
            <form action="process/ReservationProcess.php" method="post" class="reservation-form" enctype="multipart/form-data">

                <div class="container section-title text-center">
                    <h3>New Reservation</h3>
                </div>
                <div class="row gy-4">

                  <input type="hidden" name="userID" value="<?php echo htmlspecialchars($_SESSION['userID'] ?? ''); ?>">
                  
                  <div class="col-6">
                    <input type="text" name="firstname" class="form-control" value="<?php echo htmlspecialchars($_SESSION['firstname'] ?? ''); ?>" readonly>
                  </div>

                  <div class="col-6">
                      <input type="text" name="lastname" class="form-control" value="<?php echo htmlspecialchars($_SESSION['lastname'] ?? ''); ?>" readonly>
                  </div>

                  <div class ="col-12">
                    <select name="service" id="service" class="form-select" required>
                      <option value="" disabled selected>Select Service</option>
                      <option value="Studio Rental">Studio Rental</option>
                      <option value="Recording">Recording</option>
                      <option value="Drum Lesson">Drum Lesson</option>
                    </select>
                  </div>

                  <!-- Extra Fields: Only for Studio Rental -->
                  <div id="studio-fields" class="row gy-4" style="display: none;">

                    <div class="col-12">
                      <input type="text" name="bandname" class="form-control" value="Band Name">
                    </div>

                    <div class="col-sm-4">
                      <label for="date" class="form-label">Select Date:</label>
                      <input type="date" id="studio-date" name="date" class="form-control" required>
                    </div>

                    <div class="col-sm-4">
                      <label for="start-time" class="form-label">Start Time:</label>
                      <input type="time" id="start-time" name="start-time" class="form-control">
                    </div>

                    <div class="col-sm-4">
                      <label for="end-time" class="form-label">End Time:</label>
                      <input type="time" id="end-time" name="end-time" class="form-control">
                    </div>

                    <!-- Two Column Checkboxes -->
                    <div class="col-12 mt-3">
                      <div class="row">

                        <!-- Additionals Column -->
                        <div class="col-md-6">
                          <label class="form-label fw-bold">Additionals:</label>
                          <?php if ($additionals && $additionals->num_rows > 0): ?>
                            <?php while ($row = $additionals->fetch_assoc()): ?>
                              <div class="form-check">
                                <input class="form-check-input additional-checkbox" type="checkbox" id="additional-<?php echo $row['addID']; ?>" name="additionals[]" value="<?php echo htmlspecialchars($row['addName']); ?>" data-price="<?php echo $row['price']; ?>">
                                <label class="form-check-label" for="additional-<?php echo $row['addID']; ?>">
                                  <?php echo htmlspecialchars($row['addName']); ?> (₱<?php echo number_format($row['price'], 2); ?>)
                                </label>
                              </div>
                            <?php endwhile; ?>
                          <?php else: ?>
                            <p>No additionals available.</p>
                          <?php endif; ?>
                        
                          <!-- Totals under Additionals -->
                          <div class="mt-3">
                            <label class="form-label fw-bold">Total Hours:</label>
                            <input type="text" id="total-hours" name="total-hours" class="form-control mb-2" readonly>

                            <label class="form-label fw-bold">Total Amount (₱):</label>
                            <input type="text" id="total-amount" name="total-amount" class="form-control" readonly>
                          </div>

                        </div>

                        <!-- Upload Image Column (beside Additionals) -->
                        <div class="col-md-6">
                          <label class="form-label fw-bold">Upload Receipt:</label>
                          <div class="mb-2">
                            <input type="file" id="rental-image" name="rental-image" accept="image/*" class="form-control">
                          </div>
                          <div class="mb-2">
                            <img id="rental-image-preview" src="" alt="Preview" style="max-width:100%; height:auto; display:none; border:1px solid #ddd; padding:6px;" />
                          </div>

                          <hr />
                          <div class="text-center">
                            <label class="form-label fw-bold">GCash (Down Payment):</label>
                            <div class="mb-2">
                              <img src="assets/img/QR_Payment.png" alt="GCash QR" style="max-width:200px; height:auto; border:1px solid #ddd; padding:6px;" />
                            </div>
                            <p class="small" style="color:#adb5bd;">Scan this QR code with GCash to pay at least half of total payment. After payment, you may upload the receipt above.</p>
                          </div>
                        </div>

                      </div>
                    </div>

                    <!-- totals moved into upload column -->
                  </div>

                  <!-- Extra Fields: Only for Recording -->
                  <div id="recording-fields" class="row gy-4" style="display: none;">

                    <div class="col-12">
                      <label class="form-label fw-bold">Recording Mode:</label><br>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="recording-mode" id="multitrack" value="MultiTrack" required>
                        <label class="form-check-label" for="multitrack">Multi Track</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="recording-mode" id="livetrack" value="LiveTrack" required>
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

                    <div class="col-sm-4">
                      <label for="date" class="form-label">Select Date:</label>
                      <input type="date" id="date" name="date" class="form-control">
                    </div>

                    <div class="col-sm-4">
                      <label for="start-time" class="form-label">Start Time:</label>
                      <input type="time" id="start-time" name="start-time" class="form-control">
                    </div>

                    <div class="col-sm-4">
                      <label for="end-time" class="form-label">End Time:</label>
                      <input type="time" id="end-time" name="end-time" class="form-control">
                    </div>

                    <div class="col-12">
                      <label for="recording-notes" class="form-label">Notes:</label>
                      <textarea id="recording-notes" name="recording-notes" class="form-control" rows="3" placeholder="Enter any notes or requirements..."></textarea>
                    </div>

                    <!-- Recording Receipt Upload & QR -->
                    <div class="col-12">
                      <div class="row">
                        <div class="col-md-6">
                          <label class="form-label fw-bold">Upload Receipt (Recording):</label>
                          <div class="mb-2">
                            <input type="file" id="recording-image" name="recording-image" accept="image/*" class="form-control">
                          </div>
                          <div class="mb-2">
                            <img id="recording-image-preview" src="" alt="Preview" style="max-width:100%; height:auto; display:none; border:1px solid #ddd; padding:6px;" />
                          </div>
                          <small class="small" style="color:#adb5bd;" >Upload payment receipt here.</small>
                          
                          <!-- Total Price below upload (left of QR) -->
                          <div class="mt-3">
                            <label class="form-label fw-bold">Total Price (₱):</label>
                            <input type="text" id="recording-total-price" name="recording-total-price" class="form-control" readonly>
                          </div>
                        </div>
                        <div class="col-md-6 text-center">
                          <label class="form-label fw-bold">GCash (Down Payment):</label>
                          <div class="mb-2">
                            <img src="assets/img/QR_Payment.png" alt="GCash QR" style="max-width:200px; height:auto; border:1px solid #ddd; padding:6px;" />
                          </div>
                          <p class="small" style="color:#adb5bd;">Scan this QR code with GCash to pay at least half of total payment.</p>
                        </div>
                      </div>
                    </div>

                    <!-- Total Price moved into left column of recording upload row -->
                  </div>

                  <!-- Submit Button -->
                  <div class="col-12 text-center">
                    <button type="submit" class="btn btn-primary mt-3">Submit Reservation</button>
                  </div>

                </div>
            </form>
          </div>
        </div>
      </div>
      
    </section>

  </body>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
    <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>

    <!-- Main JS File -->
    <script src="assets/js/main.js"></script>
    <!-- Reservation confirmed modal -->
    <div class="modal fade" id="reservedModal" tabindex="-1" aria-labelledby="reservedModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="reservedModalLabel">Reservation Confirmed</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Your reservation has been received. Thank you! We will contact you with details shortly.
          </div>
          <div class="modal-footer">
            <a href="customer-dashboard.php" class="btn btn-primary">Go to Dashboard</a>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Reservation error modal -->
    <div class="modal fade" id="reservedErrorModal" tabindex="-1" aria-labelledby="reservedErrorModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="reservedErrorModalLabel">Reservation Failed</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            We couldn't complete your reservation. Please try again or contact support.
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Try Again</button>
            <a href="contact.php" class="btn btn-secondary">Contact Support</a>
          </div>
        </div>
      </div>
    </div>
    <script>
      // Pricing rules injected from server (service_pricings for Studio Rental)
      window.studioPricings = <?php echo json_encode($studioPricings, JSON_HEX_TAG|JSON_HEX_AMP|JSON_HEX_APOS|JSON_HEX_QUOT); ?> || [];
    </script>
    <script>
      // Show reservation confirmation modal when ?reserved=1 is present
      (function(){
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
</body>
</html>