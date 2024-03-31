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
        $this->$_POST = $input;
        $this->loadData(); 
    }

public function run(){
        // Get the command
        $command = "example";
        if (isset($this->$_POST["command"]))
            $command = $this->$_POST["command"];
        
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

public function loadData (){
    $this->data = json_decode(
        file_get_contents("/data/connections.json"), true);
}
public function login() {
    if (isset($_POST["name"]) && isset($_POST["email"]) &&
        !empty($_POST["name"]) && !empty($_POST["email"])) {
        $_SESSION["name"] = $_POST["name"];
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
    $name = isset($_SESSION["name"]) ? $_SESSION["name"] : "";
    $email = isset($_SESSION["email"]) ? $_SESSION["email"] : "";
    $score = isset($_SESSION["score"]) ? $_SESSION["score"] : "";
    include("../views/game.php");
}

public function exitGame() {
    session_destroy();
    session_start();
}


}