<?php
require_once"includes/config_session.inc.php";

require_once"includes/dbh.inc.php";

$userId = $_SESSION["user_id"];
$query = "SELECT *
FROM job J JOIN member_account M ON J.member_user_id = M.member_user_id";
$result = pg_query($conn, $query);

if ($result) {
    $jobs = pg_fetch_all($result);
} else {
    echo"Error fetching jobs: " . pg_last_error($conn);
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
    .job-container {
        margin-bottom: 20px;
        padding: 10px;
        border: 1px solid #ccc;
    }
    </style>
    <!-- Add jQuery library (if not already included) -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- Your JavaScript code goes here -->
    <script>
        // JavaScript function to handle job application
        function applyForJob(jobId) {
            // Perform AJAX request to submit job application
            $.ajax({
                type: "POST",
                url: "includes/apply_job.inc.php",
                data: { job_id: jobId },
                success: function(response) {
                    // Show pop-up window with the message
                    alert("Your application was sent");
                    // You can customize the pop-up or use a modal here
                },
                error: function(error) {
                    console.log("Error submitting application: " + error);
                }
            });
        }
    </script>
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

<h1>Available Jobs</h1>

<?php if (!empty($jobs)): ?>
    <?php foreach ($jobs as $job): ?>
        <div class="job-container">
            <h2><?php echo $job['required_caregiving_type']; ?></h2>
            <p>Requirements: <?php echo $job['other_requirements']; ?></p>
            <p>House rules: <?php echo $job['house_rules']; ?></p>
            <p>Date posted: <?php echo $job['date_posted']; ?></p>

            <!-- "Apply" button with pop-up confirmation -->
            <button class="apply-button" onclick="applyForJob(<?php echo $job['job_id']; ?>)">Apply</button>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>No jobs available.</p>
<?php endif; ?>


</main>
    
</body>
</html>