<?php
session_start();
session_destroy();

// Redirect to the index
header('Location: welcome.php');
exit();