<?php
require_once"config_session.inc.php";



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $mail = $_POST["mail"];
    $user_password = $_POST["password"];

   require_once"dbh.inc.php";


   $query = "SELECT user_password, user_id FROM user_account WHERE email = $1";
   $result = pg_query_params($conn, $query, array($mail));

   if (!$result){
    die("Query failed: ".pg_last_error());
   }

   $row = pg_fetch_assoc($result);

   $userID = $row["user_id"];
   $memberQuery = "SELECT * FROM member_account WHERE member_user_id = $1";
   $memberResult = pg_query_params($conn, $memberQuery, array($userID));

   $location = "Location: ../signin.php";

   if ($memberResult){
    if (pg_num_rows($memberResult) == 1){
        $location = "Location: ../memberside.php";
    }
   }


   $caregiverQuery = "SELECT * FROM caregiver WHERE caregiver_user_id = $1";
   $caregiverResult = pg_query_params($conn, $caregiverQuery, array($userID));

   if ($caregiverResult){
    if (pg_num_rows($caregiverResult) == 1){
        $location = "Location: ../caregiverside.php";
    }
   }

   if ($row){
    $dbpwd = $row["user_password"];
    
    if(password_verify($user_password, $dbpwd)){
        echo "Login Successfull!";
        $_SESSION["user_id"] = $userID;
        header($location);
    } else{
        echo "Invalid password";
    }

   } else {
    echo "User not found";
   }

   pg_close($conn);

   //header("Location: ../memberside.php");

} else{
    header("Location: ../index.php");
}