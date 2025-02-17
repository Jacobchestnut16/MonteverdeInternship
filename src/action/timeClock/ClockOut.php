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

$query = "SELECT * FROM TimeClock where userID = ".$_SESSION['uid']." order by date desc limit 1";
$result = $conn->query($query);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $query = "UPDATE TimeClock set clockOut = '".$datetime."' where id = ".$row['id'];
    if ($conn->query($query) === TRUE) {
        echo "Clocked out at " . date('h:i a', strtotime($datetime));
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }
}else{
    echo "Cannot clock out; not clocked in";
}