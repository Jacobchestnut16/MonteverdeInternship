<?php
session_start();

$servername = "database"; //will change after new env setup
$username = "user";
$password = "pass";
$dbname = "mcshedual";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    // echo "Connection failed: " . $conn->connect_error;
}

$datetime = new DateTime();
$datetime->setTimezone(new DateTimeZone('America/New_York'));
$datetime = $datetime->format('Y-m-d H:i:s');

$query = "INSERT INTO TimeClock (date,userID) VALUES ('$datetime','".$_SESSION['uid']."')";
if ($conn->query($query) === TRUE) {
    echo "Clocked in at " . date( 'h:i a', strtotime($datetime));
    echo "<br>";
    echo "<form action='/action/timeClock/ClockOut.php' method='post'><button type='submit'>Clock Out</button></form>";
}else{
    echo "Error: " . $query . "<br>" . $conn->error;
}