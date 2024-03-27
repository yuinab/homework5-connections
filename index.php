<?php
session_start();
$request = $_GET['command'] ?? '';

switch ($request) {
    // For starting the game
    case 'startGame':
        // Process the form data
        $_SESSION['name'] = trim($_POST['name']);
        $_SESSION['email'] = trim($_POST['email']);
        header('Location: views/game.php');
        exit();
        break;
    
    // For exiting the game
    case 'exitGame':
        // Clear
        $_SESSION = array();

        // Delete cookie
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();

        header('Location: index.php?command=welcome');
        exit();
        break;
    
    // No specific command show the welcome page if not already playing
    default:
        if (!isset($_SESSION['name']) || !isset($_SESSION['email'])) {
            include('views/welcome.php');
        } else {
            // User has already entered details redirect to the main game page
            header('Location: views/game.php');
            exit();
        }
        break;
}
?>
