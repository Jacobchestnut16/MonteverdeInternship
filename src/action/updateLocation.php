<?php
$servername = "database"; //will change after new env setup
$username = "user";
$password = "pass";
$dbname = "mcshedual";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo "Connection failed: " . $conn->connect_error;
}

$query = "UPDATE EventLocation SET location='".$_POST["eventValue"]."',color='".$_POST['eventColor']."' WHERE id='".$_POST["eventID"]."'";

if ($conn->query($query) === TRUE) {
    echo "Record updated successfully";
    include "../nav/admin/Event.php";
} else {
    echo "Error: " . $query . "<br>" . $conn->error;
    include "../nav/admin/Event.php";
}