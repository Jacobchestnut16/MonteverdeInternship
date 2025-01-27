<?php
$servername = "database"; //will change after new env setup
$username = "user";
$password = "pass";
$dbname = "mcshedual";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo "Connection failed: " . $conn->connect_error;
}

$email = $_POST["email"];
$username = $_POST["username"];
$password  = $_POST["password"];
$phone = $_POST["phone"];
$fname = $_POST["firstname"];
$lname = $_POST["lastname"];
$privilege = 1;
$extendedView = 0;

$sql = "INSERT INTO users (username, password, email, phone, firstname, lastname, privilege, extendedView)
VALUES ($username, $password, $email, $phone, $fname, $lname, $privilege, $extendedView);";

if ($conn->query($sql) === TRUE) {
    echo "Admin user created successfully";
    include '../login.php';
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}