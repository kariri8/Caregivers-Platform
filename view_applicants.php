<?php
require_once"includes/config_session.inc.php";
require_once"includes/dbh.inc.php";

if(isset($_GET['job_id'])){
    $jobId = $_GET['job_id'];

    $query = "SELECT Ja.date_applied, C.photo, C.gender, C.caregiving_type, C.hourly_rate, U.email, U.given_name, U.surname, U.city, U.phone_number, U.profile_description
    FROM (job_application Ja JOIN caregiver C ON Ja.caregiver_user_id = C.caregiver_user_id) JOIN user_account U ON C.caregiver_user_id = U.user_id
    WHERE Ja.job_id = $1";
    $result = pg_query_params($conn, $query, array($jobId));

    if($result){
        $applicants= pg_fetch_all($result);
    } else {
        echo "Error fetching applicants: " . pg_last_error($conn);
    }
} else {
    header("Location: ../jobs.php");
    exit();
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
    .application-container {
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

<?php if (!empty($applicants)): ?>
    <ul>
        <?php foreach ($applicants as $applicant): ?>
            <div class = "application-container">
                <?php 
                $photoData = base64_encode($applicant['photo']);
                $photoSrc = 'data:image/png;base64,' . $photoData;
                ?>
                <img src="<?php echo $photoSrc; ?>" alt="Caregiver Photo" style="max-width: 100px; max-height: 100px;">
                <p>Full name:<?php echo $applicant['given_name'] . " " . $applicant['surname']; ?> </p>
                <p>Date applied: <?php echo $applicant['date_applied']; ?></p>
                <p>Caregiving type: <?php echo $applicant['caregiving_type']; ?></p>
                <p>City: <?php echo $applicant['city']; ?></p>
                <p>Gender: <?php echo $applicant['gender']; ?> </p>
                <p>Profile description: <?php $applicant['profile_description']; ?></p>
                <p>Hourly rate: <?php $applicant['hourly_rate']; ?></p>
                <p>Email: <?php $applicant['email']; ?></p>
                <p>Phone number: <?php $applicant['phone_number']; ?></p>
                <!-- Add more caregiver information as needed -->
        </div>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>No applicants found for this job.</p>
<?php endif; ?>

</main>
    
</body>
</html>