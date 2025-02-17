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

$timeClockID = isset($_POST['id'])? $_POST['id'] : -1;
$date = $_POST['in'];
$clockOut = $_POST['out'];

if ($timeClockID >= 0) {

    $query = "INSERT INTO MissedPunch (timeClockID, date, clockOut) VALUES ('$timeClockID', '$date', '$clockOut')";

    if ($conn->query($query) === TRUE) {
        echo "Added Missed Punch form successfully";
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }
}else{
    $query = "INSERT INTO TimeClock (date,clockOut,userID) VALUES ('$date','$clockOut','".$_SESSION['uid']."')";
    if ($conn->query($query) === TRUE) {
        $query = "SELECT * FROM TimeClock where userID = ".$_SESSION['uid']." order by date desc limit 1";
        $result = $conn->query($query);

        if ($result) {
            $row = $result->fetch_assoc();
            $timeClockID = $row['id'];
        } else {
            echo "Error retrieving TimeClock ID.<br>";
        }
    }

    $query = "INSERT INTO MissedPunch (timeClockID, date, clockOut) VALUES ('$timeClockID', '$date', '$clockOut')";

    if ($conn->query($query) === TRUE) {
        echo "Added Missed Punch form successfully";
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }
}