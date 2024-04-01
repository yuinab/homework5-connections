<?php
session_start();
if (isset($_SESSION['name']) && isset($_SESSION['email'])) {
    header('Location: src/connections/views/game.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name']) && isset($_POST['email'])) {
    $_SESSION['name'] = trim($_POST['name']);
    $_SESSION['email'] = trim($_POST['email']);
    $_SESSION['guesses'] = 0;
    header('Location: src/connections/views/game.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to the Connections Game</title>
    <link rel="stylesheet" href="/src/connections/styles/welcome.css">
</head>
<body>
    <div class="container">
        <h1>Welcome to the Connections Game</h1>
        <form action="?command=login" method="post">
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