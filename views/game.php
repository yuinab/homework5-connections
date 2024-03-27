<?php
session_start();
if (!isset($_SESSION['name']) || !isset($_SESSION['email'])) {
    // If the session isn't set, redirect back to the index (which will show the welcome page)
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Start</title>
</head>
<body>
    <h1>Game has started</h1>
    <!-- Put the actual game here -->
</body>
</html>
