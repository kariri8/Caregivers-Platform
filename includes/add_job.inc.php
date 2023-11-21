<?php
require_once"dbh.inc.php";
require_once"config_session.inc.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $memberID = $_SESSION["user_id"];
    $caregiving_type = $_POST["caregiving_type"];
    $description = $_POST["description"];
    $date = date("Y-m-d");

    $insertQuery = "INSERT INTO job (member_user_id, required_caregiving_type, other_requirements, date_posted) VALUES ($1,$2,$3,$4)";
    $result = pg_query_params($conn, $insertQuery, array($memberID, $caregiving_type, $description, $date));

    if(!$result){
        die("Query failed: ". pg_last_error());
    }

    header("Location: ../jobs.php");

    

}

pg_close($conn);