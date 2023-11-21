
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <title>Document</title>
</head>
<body>
    <main>
        <form action="includes/signin.inc.php" method="post">
        <label for="mail">Mail:</label><br><br>
        <input required id="mail" type="email" name="mail"><br><br>

        <label for="password">Password:</label><br><br>
        <input required id="password" type="password" name="password"><br><br><br>

        <button type="submit">Sign in</button><br><br>
        </form>
    </main>
</body>
</html>