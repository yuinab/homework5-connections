<?php
session_start();

// Redirect to the welcome page if no session
if (!isset($_SESSION['name']) || !isset($_SESSION['email'])) {
    header('Location: index.php?command=welcome');
    exit();
}

// replace this with the actual game data
$categories = $_SESSION['categories'] ?? [];
$guesses = $_SESSION['guesses'] ?? 0;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Over</title>
    <!--You might have to mess with this file path once you put in the actual game logic by removing the  ../ -->
    <link rel="stylesheet" href="../styles/gameover.css">
</head>
<body>
    <div class="container">
        <h1>Game Over</h1>
        <p>Well done, <?php echo htmlspecialchars($_SESSION['name']); ?>! Here's how you did:</p>

        <div class="results">
            <h2>Categories and Words</h2>
            <?php foreach ($categories as $category => $words): ?>
                <p><strong><?php echo htmlspecialchars($category); ?>:</strong> <?php echo htmlspecialchars(implode(', ', $words)); ?></p>
            <?php endforeach; ?>
            
            <p>Total guesses: <?php echo $guesses; ?></p>
        </div>

        <div class="actions">
            <a href="../index.php?command=startGame">Play Again</a> |
            <a href="../index.php?command=exitGame">Exit</a>
        </div>
    </div>
</body>
</html>
