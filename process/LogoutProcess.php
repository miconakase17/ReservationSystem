<?php
session_start();

// Destroy session
session_unset();
session_destroy();

// Redirect to login page with a query parameter
header("Location: login.php?logout=1");
exit();
?>
