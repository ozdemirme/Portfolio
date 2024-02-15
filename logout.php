<?php
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session, what is this
session_destroy();

// Redirect to the login page or any other page after logout
header("Location: index.php");
exit();
?>
