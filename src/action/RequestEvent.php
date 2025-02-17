<?php
$servername = "database"; //will change after new env setup
$username = "user";
$password = "pass";
$dbname = "mcshedual";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo "Connection failed: " . $conn->connect_error;
}

session_start();
$uID = $_SESSION['uid'];

foreach ($_GET['events'] as $id) {
    echo "<p>Requesting ................... begin</p>";
    $query = "INSERT INTO UserEventRequest (eventID, userID) VALUES ($id, $uID)";
    if ($conn->query($query) === TRUE) {
        echo "<p>Requested ............. successfully</p>";
    }else{
        echo "<p>Requesting .................. Failed</p>";
    }
}
