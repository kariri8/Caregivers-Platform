<?php

require_once"includes/dbh.inc.php";
require_once"includes/config_session.inc.php";

$query = "SELECT Ad.town, Ad.street, Ad.house_number,A.appointment_id, A.status, A.work_hours, A.appointment_time, A.appointment_date, M.house_rules, U.email, U.given_name, U.surname, U.phone_number, U.profile_description
FROM ((appointment A JOIN member_account M ON A.member_user_id = M.member_user_id) 
		JOIN user_account U on U.user_id = A.member_user_id) 
		JOIN address Ad ON Ad.member_user_id = A.member_user_id
WHERE A.caregiver_user_id = $1";
$result = pg_query_params($conn,$query, array($_SESSION['user_id']));

if($result){
    $appointments = pg_fetch_all($result);
}else{
    echo "Error fetching appointments: ". pg_last_error($conn);
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
    <!-- Add jQuery library (if not already included) -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- Your JavaScript code goes here -->
    <script>
        // JavaScript function to handle confirmation or decline of appointments
        function handleAppointment(appointmentId, action) {
            // Perform AJAX request to update appointment status
            $.ajax({
                type: "POST",
                url: "includes/update_appointment_status.php",
                data: { appointment_id: appointmentId, action: action },
                success: function(response) {
                    // Update the UI or perform additional actions as needed
                    alert(response); // Display a message (you can customize this)
                    // Reload the appointments or update the UI dynamically
                    location.reload();
                },
                error: function(error) {
                    console.log("Error updating appointment status: " + error);
                }
            });
        }
    </script>
</head>
<body>
<ul class="navbar">
    <li class="nav-item"><a href="jobs.php">Jobs</a></li>
    <li class="nav-item"><a href="appointments.php">Appointments</a></li>
    <li class="nav-item" style="float: right;"><a href="caregiverside.php">My Profile</a>
    <li class="nav-item" style="float: right;"><a href="includes/logout.php">Log out</a>
</li>
</ul>

<main>
<h1>Your Appointments</h1>

<?php if (!empty($appointments)): ?>
    <?php foreach ($appointments as $appointment): ?>
        <div class="appointment-container">
            <h2>Appointment with Member <?php echo $appointment['given_name'] . " ". $appointment['surname']; ?></h2>
            <p>Profile description: <?php echo $appointment['profile_description']; ?></p>
            <p>House rules: <?php echo $appointment['house_rules']; ?></p>
            <p>Date: <?php echo $appointment['appointment_date']; ?></p>
            <p>Time: <?php echo $appointment['appointment_time']; ?></p>
            <p>Work hours: <?php echo $appointment['work_hours']; ?></p>
            <p>Status: <?php echo $appointment['status']; ?></p>

            <!-- Confirm and Decline buttons -->
            <?php if ($appointment['status'] === null ): ?>
                <button onclick="handleAppointment(<?php echo $appointment['appointment_id']; ?>, 'confirm')">Confirm</button>
                <button onclick="handleAppointment(<?php echo $appointment['appointment_id']; ?>, 'decline')">Decline</button>
            <?php elseif ($appointment['status'] === 'confirmed'): ?>
                <p>Member email: <?php echo $appointment['email']; ?></p>
                <p>Member phone number: <?php echo $appointment['phone_number']; ?></p>
                <p>Member address: <?php echo $appointment['town'] . ", " . $appointment["street"] . ", " . $appointment["house_number"]; ?> </p>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>No appointments available.</p>
<?php endif; ?>

</main>


</body>
</html>