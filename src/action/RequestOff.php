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

$from = date('Y-m-d', strtotime($_POST["dateo"]));
$to = date('Y-m-d', strtotime($_POST["datei"]));
$start = $from;

while (strtotime($start) <= strtotime($to)) {
    $query = "INSERT INTO UsersUnavailableDates (userID, date) values (".$_SESSION['uid'].", '" . $start . "')";
    if ($conn->query($query) === TRUE) {
        echo "<p>Added date: ".$start."</p>";
    }else{
        echo "<p>Error while adding a date</p>";
    }
    $start = date('Y-m-d', strtotime('+1 day', strtotime($start)));
}
echo "<a href='/nav/RequestOff.php'>View Requests</a>";
