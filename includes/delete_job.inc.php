<?php
require_once"config_session.inc.php";
require_once "dbh.inc.php";

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $jobId = $_POST['job_id'];

    $query = "DELETE FROM job WHERE job_id = $1 AND member_user_id = $2";
    $result = pg_query_params($conn, $query, array($jobId, $_SESSION['user_id']));

    if($result){
        header("Location: ../jobs.php");
    } else{
        echo "Error deleting job: " . pg_last_error($conn);
    }

}

pg_close($conn);