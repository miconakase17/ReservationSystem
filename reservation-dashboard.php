<?php
session_start();  
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

      <a href="index.html" class="logo d-flex align-items-center me-auto">
        <h1 class="sitename">Kevin's Express Studio</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="#hero">Home</a></li>
          <li><a href="#about">View Reservation</a></li>
          <li><a href="#services">Profile</a></li>
          <li><a href="reservation-dashboard.html">Log Out</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <a class="cta-btn" href="">Reserve Now!</a>

    </div>
  </header>
  <body class="reservation-dashboard-page">

    <section id="reservation-section" class="reservation-section dark-background align-items-center justify-content-center min-vh-100">
      <video src="assets/video/mainvideo.mp4" autoplay muted loop playsinline></video>

      <div class="container">
        <div class="row justify-content-center"> 
          <div class="col-lg-6">
            <form action="handlers/reservation_handler.php" method="post" class="reservation-form">

                <div class="container section-title text-center">
                    <h3>New Reservation</h3>
                </div>
                <div class="row gy-4">

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

                    <!-- Two Column Checkboxes -->
                    <div class="col-12 mt-3">
                      <div class="row">
                        
                        <!-- Instruments Column -->
                        <div class="col-md-6">
                          <label class="form-label fw-bold">Instruments:</label>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="electric-guitar" name="options[]" value="Electric Guitar">
                            <label class="form-check-label" for="electric-guitar">Electric Guitar</label>
                          </div>
      
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="bass-guitar" name="options[]" value="Bass Guitar">
                            <label class="form-check-label" for="bass-guitar">Bass Guitar</label>
                          </div>

                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="drum-sticks" name="options[]" value="Drum Sticks">
                            <label class="form-check-label" for="drum-sticks">Drum Sticks</label>
                          </div>

                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="guitar-pick" name="options[]" value="Guitar Pick">
                            <label class="form-check-label" for="guitar-pick">Guitar Pick</label>
                          </div>
                        </div>

                        <!-- Additionals Column -->
                        <div class="col-md-6">
                          <label class="form-label fw-bold">Additionals:</label>
                    
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="lights" name="options[]" value="Stage Lights">
                            <label class="form-check-label" for="lights">Stage Lights</label>
                          </div>

                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="mic" name="options[]" value="Microphone">
                            <label class="form-check-label" for="mic">Microphone</label>
                          </div>
                        </div>

                      </div>
                    </div>

                    <!-- ✅ Total Hours & Total Amount -->
                    <div class="col-12 mt-4">
                      <div class="row">
                        <div class="col-md-6">
                          <label class="form-label fw-bold">Total Hours:</label>
                          <input type="text" id="total-hours" name="total-hours" class="form-control" readonly>
                        </div>
                        <div class="col-md-6">
                          <label class="form-label fw-bold">Total Amount (₱):</label>
                          <input type="text" id="total-amount" name="total-amount" class="form-control" readonly>
                        </div>
                      </div>
                    </div>


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
    <script src="assets/js/reservation.js"></script>
</body>
</html>