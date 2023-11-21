<?php
require_once"includes/config_session.inc.php";

require_once"includes/dbh.inc.php";

$userID = $_SESSION['user_id'];
$query = "SELECT given_name, surname, email, phone_number, profile_description FROM user_account WHERE user_id = $1";
$result = pg_query_params($conn, $query, array($userID));

if($result){
    $user = pg_fetch_assoc($result);
} else{
    echo "Error: ". pg_last_error($conn);
}

$memberQuery = "SELECT house_rules FROM member_account WHERE member_user_id = $1";
$memberResult = pg_query_params($conn, $memberQuery, array($userID));

if($memberResult){
    $member = pg_fetch_assoc($memberResult);
} else{
    echo "Error: ". pg_last_error($conn);
}

$addressQuery = "SELECT town, street, house_number FROM address WHERE member_user_id =$1";
$addressResult = pg_query_params($conn, $addressQuery, array($userID));

if($addressResult){
    $address = pg_fetch_assoc($addressResult);
} else{
    echo "Error: ". pg_last_error($conn);
}

pg_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/navbar.css">
    <title>Document</title>
</head>
<body>

<ul class="navbar">
    <li class="nav-item"><a href="jobs.php">Jobs</a></li>
    <li class="nav-item"><a href="appointments.php">Appointments</a></li>
    <li class="nav-item"><a href ="search.php">Search</li>
    <li class="nav-item" style="float: right;"><a href="memberside.php">My Profile</a>
    <li class="nav-item" style="float: right;"><a href="includes/logout.php">Log out</a>
</li>
</ul>

<main>

<h1>Welcome, <?php echo $user['given_name'] . " " . $user["surname"]; ?>!</h1>
<p>Email: <?php echo $user['email']; ?></p>
<p>Phone number: <?php echo $user['phone_number']; ?></p>
<p>Address: <?php echo $address['town'] . ", " . $address["street"]. ", " . $address["house_number"]; ?></p>
<p>Profile description: <?php echo $user["profile_description"]; ?></p>
<p>House rules: <?php echo $member["house_rules"]; ?></p>




</main>
    
</body>
</html>