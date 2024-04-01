<?php

class CategoryGameController {
    private $data;
    
    private $db;
    private $errorMessage = "";


    /**
     * Constructor
     */
    public function __construct($input) {
        session_start();
        $this->db = new Database();
        $this->input = $input;
        $jsonData = file_get_contents("\\connections\\data\\connections.json");
        $this->data = json_decode($jsonData, true); 
        $this->$_POST = $input;

    }

public function run(){
        // Get the command
        $command = "example";
        if (isset($this->$input["command"]))
            $command = $this->$input["command"];
        
        if (!isset($_SESSION["name"]) && $command != "login")
        $command = "welcome";

switch ($command) {
    // For starting the game
    case"login":
        $this->login(); 
        break;
    case "startGame":
        $this->showGame();
        break;
    
    // For exiting the game
    case "exitGame":
        $this->exitGame();

    
    // No specific command show the welcome page if not already playing
    default:
        $this->showWelcome();
        break;
    }

}

public function login() {
    if (isset($_POST["fullname"]) && isset($_POST["email"]) &&
        !empty($_POST["fullname"]) && !empty($_POST["email"])) {
        $_SESSION["name"] = $_POST["fullname"];
        $_SESSION["email"] = $_POST["email"];
        $_SESSION["score"] = 0;
        header("Location: ?command=startGame");
        return;
    }
    $this->errorMessage = "Error logging in - Name and email is required";
    $this->showWelcome();
}

public function showWelcome() {
    $message = "";
    if (!empty($this->errorMessage)) {
        $message = "<div class='alert alert-danger'>{$this->errorMessage}</div>";
    }
    include("../views/welcome.php");
}

public function showGame($message = "") {
    $name = $_SESSION["name"];
    $email = $_SESSION["email"];
    $score = $_SESSION["score"];
    include("../views/game.php");
}

public function exitGame() {
    session_destroy();
    session_start();
}
}