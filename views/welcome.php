<?php
session_start();

// Check if the user is already logged in
if (isset($_SESSION['name']) && isset($_SESSION['email'])) {
    // User is already logged in, redirect to the game page
    header('Location: game.php');
    exit();
}

// Process the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name']) && isset($_POST['email'])) {
    // Sanitize and validate input as necessary
    $_SESSION['name'] = trim($_POST['name']);
    $_SESSION['email'] = trim($_POST['email']);

    // Redirect to the game page
    header('Location: game.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to the Connections Game</title>
    <link rel="stylesheet" href="styles/welcome.css">
</head>
<body>
    <div class="container">
        <h1>Welcome to the Connections Game</h1>
        <form action="index.php?command=startGame" method="POST">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <button type="submit">Start Game</button>
        </form>
    </div>
</body>
</html>
