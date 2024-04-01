<?php
session_start();
$name = isset($_SESSION['name']) ? $_SESSION['name'] : '';
$email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
$guesses = isset($_SESSION['guesses']) ? $_SESSION['guesses'] : 0;


$categoriesData = json_decode(file_get_contents("../data/connections.json"), true);

// check if selected items are stored in the session
if (!isset($_SESSION['selectedItems']) || !isset($_SESSION['categories'])) {
    // 4 random categories
    $randomCategories = array_rand($categoriesData, 4);

    // Array to store selected items and categories
    $selectedItems = [];
    $categories = [];

    //  select 4 items from each
    foreach ($randomCategories as $category) {
        $items = $categoriesData[$category];
        shuffle($items); // Shuffle to get random items
        $selectedItems[$category] = array_slice($items, 0, 4); // Select the first 4 items and store them as an array
        $categories[$category] = $selectedItems[$category];
    }

    // store selected items and categories in the session
    $_SESSION['selectedItems'] = $selectedItems;
    $_SESSION['categories'] = $categories;
} else {
    $selectedItems = $_SESSION['selectedItems'];
    $categories = $_SESSION['categories'];
}

// Counter for numbering the cards from 1 to 16
$cardNumber = 1;
$displayedCardNumber = 0; 

$priorGuesses = isset($_SESSION['priorGuesses']) ? $_SESSION['priorGuesses'] : [];

// function to determine the correctness of a guess
function determineCorrectness($guess) {
    global $selectedItems;
    $correctCount = 0;
    
    $categoryWords = [];
    foreach ($selectedItems as $items) {
        $categoryWords = array_merge($categoryWords, $items);
    }

    foreach ($guess as $id) {
        $index = (int)$id - 1; 
        if (isset($categoryWords[$index])) {
            $correctCount++;
        }
    }
    
    if ($correctCount == 4) {
        return "Correct!";
    } elseif ($correctCount >= 2) {
        return "Close, but missing " . (4 - $correctCount) . " ID(s) from the same category.";
    } else {
        return "Does not contain enough valid IDs from the same category.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST["answer"])) {
        $guess = explode(" ", $_POST["answer"]);
        $priorGuesses[] = $guess;
        $_SESSION['priorGuesses'] = $priorGuesses;
        $guesses++;
        $_SESSION['guesses'] = $guesses;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to the Connections Game</title>
    <link rel="stylesheet" href="../styles/game.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>

    </style>
</head>
<body>
    <div class="container">
        <h1>Connections Game</h1>
        <h2>Welcome <?= $name ?>! (<?= $email ?>)  Guesses: <?= $guesses ?></h2>
        <div class="card-container">
            <?php foreach ($categories as $category => $items): ?>
                <?php foreach ($items as $index => $item): ?>
                    <?php if (!empty($item)): ?>
                        <div class="card">
                            <h5 class="card-title"><?= $cardNumber ?></h5>
                            <p class="card-text"><?= $item ?></p>
                        </div>
                        <?php $cardNumber++; ?>
                        <?php $displayedCardNumber++; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </div>
        
        <div class="text-center">
            <h3>Guesses:</h3>
            <p>Please enter the numeric IDs of your guesses (space separated).</p>
            <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                <div class="mb-3">
                    <label for="answer" class="form-label">Guess: </label>
                    <input type="text" class="form-control" id="trivia-answer" name="answer">
                </div>
                <button type="submit" class="btn btn-primary">Submit Answer</button>
                <a href="gameover.php" class="btn btn-danger">Quit Game</a>
            </form>
        </div>
        
        <div class="text-center mt-5">
            <h3>Prior Guesses:</h3>
            <?php foreach ($priorGuesses as $guess): ?>
                <p>
                    <?= implode(", ", $guess) ?><br>
                    <?= determineCorrectness($guess) ?>
                </p>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>

