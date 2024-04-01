<?php
session_start();

// Save name and email to temporary variables
$name = $_SESSION['name'];
$email = $_SESSION['email'];

// Destroy session
session_destroy();

// Start a new session
session_start();

// Restore name and email variables
$_SESSION['name'] = $name;
$_SESSION['email'] = $email;

// Redirect to the game page
header('Location: game.php');
exit();
?>