<?php
// Sources used: 
//https://cs4640.cs.virginia.edu/activities/php-trivia2.html
//https://cs4640.cs.virginia.edu/activities/php-trivia1.html

// DEBUGGING ONLY! Show all errors.
error_reporting(E_ALL);
ini_set("display_errors", 1);

// Class autoloading by name.  All our classes will be in a directory
// that Apache does not serve publicly.  They will be in /opt/src/, which
// is our src/ directory in Docker.
spl_autoload_register(function ($classname) {
    // Convert namespace separator to directory separator
    $filename = str_replace("\\", DIRECTORY_SEPARATOR, $classname);

    // Define directories to search for class files
    $directories = [
        __DIR__ . "/src/$filename.php",                  // For CategoryGameController
        __DIR__ . "/src/example/$filename.php"          // For Database in the example directory
    ];

    // Loop through directories and include the class file if found
    foreach ($directories as $file) {
        if (file_exists($file)) {
            include $file;
            return;  // Stop looping once class file is included
        }
    }

    // If class file is not found, output an error message
    echo "File not found for class: $classname";
});

// Other global things that we need to do
// (such as starting a session, coming soon!)

// Instantiate the front controller
$game = new CategoryGameController($_GET);

// Run the controller
$game->run();
