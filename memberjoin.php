

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
        <form action="includes/addmember.inc.php" method="post">
            <label for="given_name">First Name:</label><br><br>
            <input required id="given_name" type = "text" name="given_name" placeholder="First Name..."><br><br>

            <label for="surname">Surname:</label><br><br>
            <input required id="surname" type="text" name="surname" placeholder="Surname..."><br><br>

            <label for="mail">Mail address:</label><br><br>
            <input required id="mail" type="email" name="mail" placeholder="Mail address..."><br><br>

            <label for="phone">Phone number:</label><br><br>
            <input required id="phone" type="tel" name="phone" placeholder="+77777777777" pattern="+[0-9]{11}"><br><br>
            <small>Format: +77777777777</small><br><br>

            <label for="town">City:</label><br><br>
            <input required id="town" type="text" name="town" placeholder="Astana..."><br><br>

            <label for="housenumber">House number:</label><br><br>
            <input id="housenumber" type="text" name="housenumber" placeholder="123..."><br><br>

            <label for="street">Street:</label><br><br>
            <input id="street" type="text" name="street" placeholder="Kabanbay Batyr..."><br><br>

            <label for="description">Information about person in need:</label><br><br>
            <textarea id="description" name="description" rows="4" cols = "50" placeholder="I have a 5-year old son who likes painting…"></textarea><br><br>

            <label for="rules">House rules:</label><br><br>
            <textarea id="rules" name="rules" rows="4" cols = "50" placeholder="The caregiver should pay attention to hygiene…"></textarea><br><br>

            <label for="password">Password:</label><br><br>
            <input required id="password" type="password" name="password"><br><br><br>

            <button type="submit">Sign up</button><br><br>
        </form>
    </main>

</body>
</html>