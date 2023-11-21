<?php
require_once("config_session.inc.php");

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $given_name = $_POST["given_name"];
    $surname = $_POST["surname"];
    $caregiving_type = $_POST["caregiving_type"];
    $email = $_POST["mail"];
    $gender = $_POST["gender"];
    $photoContent = null;
    $phone = $_POST["phone"];
    $town = !empty($_POST["town"]) ? $_POST["town"] : null;
    $hourly_rate = !empty($_POST["hourly_rate"]) ? $_POST["hourly_rate"] : null;
    $description = !empty($_POST["description"]) ? $_POST["description"] : null;
    $user_password = $_POST["password"];

    $hashedPwD = password_hash($user_password, PASSWORD_DEFAULT);

    if(isset($_FILES['photo']) && $_FILES['photo']['error'] == UPLOAD_ERR_OK){
        $photoContent = file_get_contents($_FILES['photo']['tmp_name']);
    }

    require_once"dbh.inc.php";

    $insertUserQuery = "INSERT INTO user_account (email, given_name, surname, city, phone_number, profile_description, user_password) VALUES ($1,$2,$3,$4,$5,$6,$7) RETURNING user_id";
    $result = pg_query_params($conn, $insertUserQuery, array($email, $given_name, $surname, $town, $phone, $description, $hashedPwD));

    if(!$result){
        die("Query failed: ". pg_last_error());
    }

    $row = pg_fetch_array($result);
    $userID = $row["user_id"];

    $insertCaregiverQuery = "INSERT INTO caregiver (caregiver_user_id, photo, gender, caregiving_type, hourly_rate) VALUES ($1,$2,$3,$4,$5)";
    $resultCaregiver = pg_query_params($conn, $insertCaregiverQuery, array($userID, $photoContent, $gender, $caregiving_type, $hourly_rate));

    if(!$resultCaregiver){
        die("Query failed: ". pg_last_error());
    }

    $_SESSION["user_id"] = $userID;
    header("Location: ../caregiverside.php");
    

    pg_close($conn);
}

