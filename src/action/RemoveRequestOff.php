<?php

$servername = "database"; //will change after new env setup
$username = "user";
$password = "pass";
$dbname = "mcshedual";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    // echo "Connection failed: " . $conn->connect_error;
}

session_start();

foreach ($_POST['dates'] as $id) {
    $query = "DELETE FROM UsersUnavailableDates WHERE id = '$id'";
    if ($conn->query($query) === TRUE) {
        echo "<p>Removed date</p>";
    }else{
        echo "<p>Error while removing a date</p>";
    }
}

echo "<a href='/nav/RequestOff.php'>View Requests</a>";
