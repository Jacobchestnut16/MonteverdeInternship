<?php
$servername = "database"; //will change after new env setup
$username = "user";
$password = "pass";
$dbname = "mcshedual";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo "Connection failed: " . $conn->connect_error;
}

$query = "INSERT INTO EventType (eventType) values ('".$_POST["eventType"]."')";

if ($conn->query($query) === TRUE) {
    echo "New record created successfully";
    include "../nav/admin/Event.php";
}else{
    echo "Error: " . $query . "<br>" . $conn->error;
    include "../nav/admin/Event.php";
}