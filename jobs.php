<?php
require_once"includes/config_session.inc.php";

require_once"includes/dbh.inc.php";

$userId = $_SESSION["user_id"];
$query = "SELECT J.job_id, COUNT(A.caregiver_user_id) AS anum, J.member_user_id, J.required_caregiving_type, J.other_requirements, J.date_posted 
        FROM job J LEFT JOIN job_application A ON J.job_id = A.job_id
        WHERE J.member_user_id = $1
        GROUP BY J.job_id, J.member_user_id, J.required_caregiving_type, J.other_requirements, J.date_posted";
$result = pg_query_params($conn, $query, array($userId));

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

    .create-job-popup {
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
<h1>Jobs Page</h1>

<!-- "Create Job" button to open the pop-up window -->
<button onclick="openCreateJobPopup()">Create Job</button>

<!-- Pop-up window for creating a new job -->
<div id="createJobPopup" class="create-job-popup">
    <h2>Create Job</h2>
    <!-- Your job creation form goes here -->
    <form action="includes/add_job.inc.php" method="post">
        <label for="required_caregiving_type">Caregiving type :</label>
        <select required id="caregiving_type" name="caregiving_type" placeholder="Caregiving type...">
            <option value="babysitter">Babysitter</option>
            <option value="caregiver for elderly">Caregiver for elderly </option>
            <option value="playmate for children">Playmate for children</option>
        </select><br><br>

        <label for="description">Job Description:</label>
        <textarea id="description" name="description" rows="4" cols="50" required></textarea><br><br>

        <!-- Add more fields as needed -->

        <button type="submit">Create Job</button>
    </form>
    <button onclick="closeCreateJobPopup()">Close</button>
</div>
<br><br>

<!-- Display jobs posted by the user -->
<?php if (!empty($jobs)): ?>
    <?php foreach ($jobs as $job): ?>
        <div class="job-container">
            <h2><?php echo $job['required_caregiving_type']; ?></h2>
            <p>Requirements: <?php echo $job['other_requirements']; ?></p>
            <p>Date posted: <?php echo $job['date_posted']; ?></p>
            <p>People applied: <?php echo $job['anum']; ?> </p>

            <form action="view_applicants.php" method="get" style="display: inline-block;">
                <input type="hidden" name="job_id" value="<?php echo $job['job_id']; ?>">
                <button type="submit">View Applicants</button>
            </form>

            <form action="includes/delete_job.inc.php" method="post">
                <input type="hidden" name="job_id" value="<?php echo $job['job_id']; ?>">
                <button type="submit">Delete</button>
            </form>

        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>No jobs posted yet.</p>
<?php endif; ?>



<script>
    // JavaScript functions to handle pop-up window
    function openCreateJobPopup() {
        document.getElementById('createJobPopup').style.display = 'block';
    }

    function closeCreateJobPopup() {
        document.getElementById('createJobPopup').style.display = 'none';
    }
</script>

</main>

    
</body>
</html>