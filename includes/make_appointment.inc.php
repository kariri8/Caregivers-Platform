<?php

require_once"dbh.inc.php";

require_once"config_session.inc.php";

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $memberID = $_SESSION["user_id"];
    $caregiverID = $_POST["caregiver_id"];
    $date = $_POST["appointment_date"];
    $time = $_POST["appointment_time"];
    $hours = $_POST["work_hours"]*60*60;

    $query = "INSERT INTO appointment (caregiver_user_id, member_user_id, appointment_date, appointment_time, work_hours) VALUES ($1,$2,$3,$4,$5)";
    $result = pg_query_params($conn, $query, array($caregiverID, $memberID, $date, $time, $hours));

    if(!$result){
        die("Query failed: ". pg_last_error());
    }

    header("Location: ../search.php");

}

pg_close($conn);


