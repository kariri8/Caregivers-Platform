<?php

require_once"dbh.inc.php";
require_once"config_session.inc.php";

if(isset($_POST['job_id'])){

    $userId = $_SESSION['user_id'];
    $jobId = $_POST['job_id'];
    $date = date('Y-m-d');

    $query = ("INSERT INTO job_application (caregiver_user_id, job_id, date_applied) VALUES ($1, $2, $3)");
    $result = pg_query_params($conn, $query, array($userId, $jobId, $date));

    if(!$result){
        die("Query failed: ". pg_last_error());
    }

    header("Location: ../jobs.c.php");
}

pg_close($conn);