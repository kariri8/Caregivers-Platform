<?php
require_once"includes/config_session.inc.php";
require_once"includes/dbh.inc.php";

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $city = $_POST["city"];
    $caregiving = $_POST["caregiving"];

    $query = "SELECT C.caregiver_user_id, C.photo, C.gender, C.caregiving_type, C.hourly_rate, U.given_name, U.surname, U.city, U.profile_description
    FROM caregiver C JOIN user_account U ON C.caregiver_user_id = U.user_id
    WHERE U.city ILIKE $1 AND C.caregiving_type = $2";
    $result = pg_query_params($conn, $query, array($city, $caregiving));

    if($result){
        $caregivers = pg_fetch_all($result);
    }else{
        echo "Error fetching caregivers: " . pg_last_error($conn);
    }
}

pg_close($conn);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/navbar.css">
    <style>
        .caregiver-container {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ccc;
        }

        .appointment-popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            background: #fff;
            border: 1px solid #ccc;
            z-index: 1000;
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
<h1>Search Caregivers</h1>

<!-- Search form -->
<form action="search.php" method="post">
    <label for="city">City:</label>
    <input type="text" id="city" name="city" placeholder="Enter city">
    
    <label for="caregiving">Caregiving Type:</label>
    <select required id="caregiving" name="caregiving" >
        <option value="babysitter">Babysitter</option>
        <option value="caregiver for elderly">Caregiver for elderly </option>
        <option value="playmate for children">Playmate for children</option>
    </select>
    
    <button type="submit">Search</button>
</form>

<!-- Display search results -->
<?php if (!empty($caregivers)): ?>
    <?php foreach ($caregivers as $caregiver): ?>
        <div class="caregiver-container">
            <h2><?php echo $caregiver['given_name'] . ' ' . $caregiver['surname']; ?></h2>
            <?php 
            $photoData = base64_encode($caregiver['photo']);
            $photoSrc = 'data:image/png;base64,' . $photoData;
            ?>
            <img src="<?php echo $photoSrc; ?>" alt="Caregiver Photo" style="max-width: 100px; max-height: 100px;">
            <p>Gender: <?php echo $caregiver['gender']; ?> </p>
            <p>City: <?php echo $caregiver['city']; ?></p>
            <p>Caregiving Type: <?php echo $caregiver['caregiving_type']; ?></p>
            <p>Profile description: <?php echo $caregiver['profile_description']; ?></p>
            <p>Hourly rate: <?php echo $caregiver['hourly_rate']; ?><p>
            
            <!-- "Make an Appointment" button with a form -->
            <button class="appointment-button" onclick="openAppointmentPopup(<?php echo $caregiver['caregiver_user_id']; ?>)">Make an Appointment</button>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>No caregivers found based on the search criteria.</p>
<?php endif; ?>

<!-- Pop-up window for making an appointment -->
<div id="appointmentPopup" class="appointment-popup">
    <span class="close" onclick="closeAppointmentPopup()">&times;</span>
    <h2>Make an Appointment</h2>
    <form action="includes/make_appointment.inc.php" method="post">
        <input type="hidden" id="caregiverId" name="caregiver_id" value="">
        <label for="appointmentDate">Appointment Date:</label>
        <input type="date" id="appointmentDate" name="appointment_date" required> <br><br>
        
        <label for="appointmentTime">Appointment Time:</label>
        <input type="time" id="appointmentTime" name="appointment_time" required> <br><br>
        
        <label for="workHours">Work Hours:</label>
        <input type="number" id="workHours" name="work_hours" min="1" required><br><br>
        
        <button type="submit">Submit Appointment</button>
    </form>
</div>

<script>
    // JavaScript functions to handle pop-up window
    function openAppointmentPopup(caregiverId) {
        document.getElementById('caregiverId').value = caregiverId;
        document.getElementById('appointmentPopup').style.display = 'block';
    }

    function closeAppointmentPopup() {
        document.getElementById('appointmentPopup').style.display = 'none';
    }
</script>
</main>
</body>
</html>