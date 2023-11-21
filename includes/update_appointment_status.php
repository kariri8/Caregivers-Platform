<?php
require_once"dbh.inc.php";

if(isset($_POST["appointment_id"], $_POST["action"])){
    $appointmentId = $_POST['appointment_id'];
    $action = $_POST['action'];

    if($action == 'confirm'){
        $query = "UPDATE appointment SET status = 'confirmed' WHERE appointment_id = $1";
    } elseif($action == 'decline'){
        $query = "UPDATE appointment SET status = 'declined' WHERE appointment_id = $1";
    }

    $result = pg_query_params($conn, $query, array($appointmentId));

    if(!$result){
        echo "Error updating appointment status: " . pg_last_error($conn);
    }
} else {
    echo "Invalid request";
}

pg_close($conn);