<?php

$host = "localhost";
$port = "5432";
$dbname = "CaregiversPlatform";
$user = "postgres";
$password = "akni0204";

$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password") or die("Could not connect: " . pg_last_error());

    
