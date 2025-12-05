<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Log In | Kevin's Express Studio</title>

    <link href="assets/img/headlogo.png" rel="icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900&family=Raleway&family=Inter&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="assets/css/main.css" rel="stylesheet">
    <link href="assets/css/login.css" rel="stylesheet">


</head>

<body class="login-page">

    <section id="login-section"
        class="login-section dark-background align-items-center justify-content-center min-vh-100">

        <video src="assets/video/mainvideo.mp4" autoplay muted loop playsinline></video>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <form action="process/LoginProcess.php" method="post" class="login-form">
                        <span class="form-close-btn" onclick="window.location.href='index.html'">&times;</span>

                        <div class="container section-title text-center">
                            <h3>Login</h3>
                        </div>
                        <div class="row gy-4">

                            <div class="col-12">
                                <input type="text" name="username" class="form-control" placeholder="Username" required>
                            </div>

                            <div class="col-12">
                                <input type="password" name="password" class="form-control" placeholder="Password"
                                    required>
                            </div>

                            <div class="col-12 text-center">
                                Forgot your password? <a href="forgot-password.html">Click here</a>
                            </div>

                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary">Login</button>
                            </div>
                        </div>

                        <div class="col-12 text-center mt-3">
                            Don’t have an account? <a href="signup.html">Sign up here</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

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
    <script src="assets/js/login.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Sweet Message Integration -->
    <?php if (isset($_SESSION['popup_message'])):
        $message = $_SESSION['popup_message'];
        $type = $_SESSION['popup_type'] ?? "error"; // 'error' or 'success'
        unset($_SESSION['popup_message'], $_SESSION['popup_type']);
        ?>
        <div id="loginMessage" data-message="<?= htmlspecialchars($message) ?>" data-type="<?= htmlspecialchars($type) ?>"
            style="display:none;"></div>
    <?php endif; ?>

</body>

</html>