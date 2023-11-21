<?php
require_once"config_session.inc.php";

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $given_name = $_POST["given_name"];
    $surname = $_POST["surname"];
    $email = $_POST["mail"];
    $phone = $_POST["phone"];
    $town = $_POST["town"];
    $housenumber = !empty($_POST["housenumber"]) ? $_POST["housenumber"] : null;
    $street = !empty($_POST["street"]) ? $_POST["street"] : null;
    $description = !empty($_POST["description"]) ? $_POST["description"] : null;
    $rules = !empty($_POST["rules"]) ? $_POST["rules"] : null;
    $user_password = $_POST["password"];

    $hashedPwD = password_hash($user_password, PASSWORD_DEFAULT);

    require_once"dbh.inc.php";

    $insertUserQuery = "INSERT INTO user_account (email, given_name, surname, city, phone_number, profile_description, user_password) VALUES ($1,$2,$3,$4,$5,$6,$7) RETURNING user_id";
    $result = pg_query_params($conn, $insertUserQuery, array($email, $given_name, $surname, $town, $phone, $description, $hashedPwD));

    if(!$result){
        die("Query failed: ". pg_last_error());
    }

    $row = pg_fetch_array($result);
    $userID = $row["user_id"];

    $insertMemberQuery = "INSERT INTO member_account (member_user_id, house_rules) VALUES ($1,$2)";
    $resultMember = pg_query_params($conn, $insertMemberQuery, array($userID, $rules));

    if(!$resultMember){
        die("Query failed: ". pg_last_error());
    }

    $insertAddressQuery = "INSERT INTO address (member_user_id, house_number, street, town) VALUES ($1,$2,$3,$4)";
    $resultAddress = pg_query_params($conn, $insertAddressQuery, array($userID, $housenumber, $street, $town));

    if(!$resultAddress){
        die("Query failed :". pg_last_error());
    }

    $_SESSION["user_id"] = $userID;

    header("Location: ../memberside.php");

    pg_close($conn);
}

