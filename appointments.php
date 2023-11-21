<?php

require_once"includes/config_session.inc.php";
require_once"includes/dbh.inc.php";

$userId = $_SESSION['user_id'];
$queryAppointments = "SELECT A.appointment_date, A.appointment_time, A.work_hours, A.status, C.photo, C.gender, C.caregiving_type, C.hourly_rate, U.email, U.phone_number, U.city, U.given_name, U.surname, U.profile_description
FROM (appointment A JOIN caregiver C ON A.caregiver_user_id = C.caregiver_user_id) JOIN user_account U ON U.user_id = A.caregiver_user_id
WHERE A.member_user_id = $1";
$resultAppointments = pg_query_params($conn, $queryAppointments, array($userId));

if ($resultAppointments) {
    $appointments = pg_fetch_all($resultAppointments);
} else {
    echo "Error fetching appointments: " . pg_last_error($dbconn);
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
    <style>
    .appointment-container {
        margin-bottom: 20px;
        padding: 10px;
        border: 1px solid #ccc;
    }
    </style>
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
<h1>Your Appointments</h1>

<?php if (!empty($appointments)): ?>
    <ul>
        <?php foreach ($appointments as $appointment): ?>
            <div class = "appointment-container">
                <h2><?php echo $appointment['given_name'] . ' ' . $appointment['surname']; ?></h2>
                <?php 
                $photoData = base64_encode($appointment['photo']);
                $photoSrc = 'data:image/png;base64,' . $photoData;
                ?>
                <img src="<?php echo $photoSrc; ?>" alt="Caregiver Photo" style="max-width: 100px; max-height: 100px;">
                <p>Gender: <?php echo $appointment['gender']; ?> </p>
                <p>City: <?php echo $appointment['city']; ?></p>
                <p>Caregiving Type: <?php echo $appointment['caregiving_type']; ?></p>
                <p>Profile description: <?php echo $appointment['profile_description']; ?></p>
                <p>Hourly rate: <?php echo $appointment['hourly_rate']; ?><p>
                <strong>Appointment Date:</strong> <?php echo $appointment['appointment_date']; ?><br>
                <strong>Appointment Time:</strong> <?php echo $appointment['appointment_time']; ?><br>
                <strong>Work Hours:</strong> <?php echo $appointment['work_hours']; ?><br>
                <strong>Status:</strong> <?php echo $appointment['status']; ?><br>

                <?php if ($appointment['status'] == 'confirmed'): ?>
                    <!-- Display caregiver details for confirmed appointments -->
                    <strong>Caregiver Details:</strong><br>
                    <strong>Email:</strong> <?php echo $appointment['email']; ?><br>
                    <strong>Phone:</strong> <?php echo $appointment['phone_number']; ?><br>
                <?php endif; ?>
                </div>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>No appointments found.</p>
<?php endif; ?>

</main>

</body>
</html>