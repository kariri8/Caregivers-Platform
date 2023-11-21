

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
        <form action="includes/addcaregiver.inc.php" method="post">
            <label for="given_name">First Name:</label><br><br>
            <input required id="given_name" type = "text" name="given_name" placeholder="First Name..."><br><br>

            <label for="surname">Surname:</label><br><br>
            <input required id="surname" type="text" name="surname" placeholder="Surname..."><br><br>

            <label for="caregiving_type"> Caregiving type: </label><br><br>
            <select required id="caregiving_type" name="caregiving_type" placeholder="Caregiving type...">
                <option value="babysitter">Babysitter</option>
                <option value="caregiver for elderly">Caregiver for elderly </option>
                <option value="playmate for children">Playmate for children</option>
            </select><br><br>

            <label for="gender">Gender:</label><br><br>
            <select required id ="gender" name="gender" placeholder="Gender...">
                <option value="female">Female</option>
                <option value="male">Male</option>
            </select><br><br>

            <label for="photo">Photo:</label><br>
            <input id="photo" type="file" name="photo"><br><br>
            
            <label for="mail">Mail address:</label><br><br>
            <input required id="mail" type="email" name="mail" placeholder="Mail address..."><br><br>

            <label for="phone">Phone number:</label><br><br>
            <input required id="phone" type="tel" name="phone" placeholder="+77777777777" pattern="+[0-9]{11}"><br><br>
            <small>Format: +77777777777</small><br><br>

            <label for="town">City:</label><br><br>
            <input id="town" type="text" name="town" placeholder="Astana..."><br><br>

            <label for="hourly_rate">Price requested per hour:</label><br><br>
            <input type="number" id="hourly_rate" name="hourly_rate" min="0" step="any"><br><br>

            <label for="description">Biography and personal information:</label><br><br>
            <textarea id="description" name="description" rows="4" cols = "50" placeholder="Education, working experience..."></textarea><br><br>

            <label for="password">Password:</label><br><br>
            <input required id="password" type="password" name="password"><br><br><br>

            <button type="submit">Sign up</button><br><br>
        </form>
    </main>

</body>
</html>