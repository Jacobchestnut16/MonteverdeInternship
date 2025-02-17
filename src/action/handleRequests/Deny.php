<?php
$servername = "database"; //will change after new env setup
$username = "user";
$password = "pass";
$dbname = "mcshedual";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo "Connection failed: " . $conn->connect_error;
}

$query = "UPDATE UserEventRequest SET approved = -1 where id='" . $_POST['id'] . "'";
if ($conn->query($query) === TRUE) {
    echo "Found Request ........ successfully";
}else{
    echo "Error: " . $query . "<br>" . $conn->error;
}