<?php
include("connect.php");
// Start the session
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to the sign-in page or any other appropriate page
header("Location: sign_in.php");
exit(); // Ensure that no further code is executed after redirection
?>
