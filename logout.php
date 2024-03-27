<?php
// This whole this is just for if you want to logout and clear the session for testing reasons just got to this url
session_start();

$_SESSION = array();

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

session_destroy();

// Redirect to the index
header('Location: index.php');
exit();
