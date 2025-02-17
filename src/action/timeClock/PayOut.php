<?php

$servername = "database"; //will change after new env setup
$username = "user";
$password = "pass";
$dbname = "mcshedual";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    // echo "Connection failed: " . $conn->connect_error;
}

foreach ($_POST['paid'] as $id) {
    $query = "UPDATE TimeClock SET paid = 1 WHERE ID = '$id'";
    if ($conn->query($query) === TRUE) {
        echo "Set paid ...... Paid";
    }else{
        echo "Set paid ...... Error";

    }
}