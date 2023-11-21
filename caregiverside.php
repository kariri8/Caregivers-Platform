<?php
require_once"includes/config_session.inc.php";

require_once"includes/dbh.inc.php";

$userID = $_SESSION['user_id'];
$query = "SELECT given_name, surname, email, phone_number, profile_description, city FROM user_account WHERE user_id = $1";
$result = pg_query_params($conn, $query, array($userID));

if($result){
    $user = pg_fetch_assoc($result);
} else{
    echo "Error: ". pg_last_error($conn);
}

$caregiverQuery = "SELECT photo, gender, caregiving_type, hourly_rate FROM caregiver WHERE caregiver_user_id = $1";
$caregiverResult = pg_query_params($conn, $caregiverQuery, array($userID));

if($caregiverResult){
    $caregiver = pg_fetch_assoc($caregiverResult);
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
    <li class="nav-item"><a href="jobs.c.php">Jobs</a></li>
    <li class="nav-item"><a href="appointments.c.php">Appointments</a></li>
    <li class="nav-item" style="float: right;"><a href="caregiverside.php">My Profile</a>
    <li class="nav-item" style="float: right;"><a href="includes/logout.php">Log out</a>
</li>
</ul>

<main>


<?php 
$photoData = base64_encode($caregiver['photo']);
$photoSrc = 'data:image/png;base64,' . $photoData;
?>
<img src="<?php echo $photoSrc; ?>" alt="Caregiver Photo" style="max-width: 100px; max-height: 100px;">
<h1>Welcome, <?php echo $user['given_name'] . " " . $user["surname"]; ?>!</h1>
<p>Gender: <?php echo $caregiver['gender']; ?></p>
<p>Caregiving type: <?php echo $caregiver['caregiving_type']; ?></p>
<p>Hourly rate: <?php echo $caregiver['hourly_rate']; ?></p>
<p>Email: <?php echo $user['email']; ?></p>
<p>Phone number: <?php echo $user['phone_number']; ?></p>
<p>City: <?php echo $user['city']; ?></p>
<p>Profile description: <?php echo $user["profile_description"]; ?></p>




</main>
    
</body>
</html>