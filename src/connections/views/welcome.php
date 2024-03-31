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
