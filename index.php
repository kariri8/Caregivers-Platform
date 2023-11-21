

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css"> 
    <title>Document</title>
</head>
<body>

    <!--<main>
        <form action="includes/formhandler.php" method="post">
            <label for="given_name">First Name</label>
            <input required id="given_name" type = "text" name="given_name" placeholder="First Name...">

            <label for="surname">Surname</label>
            <input required id="surname" type="text" name="surname" placeholder="Surname...">

            <label for="caregiving_type"> Caregiving type </label>
            <select id="caregiving_type" name="caregiving_type">
                <option value="babysitter">Babysitter</option>
                <option value="caregiver for elderly">Caregiver for elderly </option>
                <option value="playmate for children">Playmate for children</option>
            </select>

            <button type="submit">Submit</button>
        </form>
    </main>-->

    <main>

        <h1>Welcome to Caregivers Platform!</h1>
        <h2>Here, you can search for caregivers or become one!</h2>

        <form action="caregiverjoin.php" method="get">
            <button type="submit">Become a caregiver</button>
        </form>
        <br>
        <form action="memberjoin.php" method="get">
            <button type="submit">Become a member</button>
        </form> 
        <br>
        <form action="signin.php" method = "get">
            <button type="submit">Sign in</button>
        </form>
    </main>
   
    
</body>
</html>