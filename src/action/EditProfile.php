<?php
session_start();
$servername = "database"; //will change after new env setup
$username = "user";
$password = "pass";
$dbname = "mcshedual";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo "Connection failed: " . $conn->connect_error;
}

try{

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $firstname = $_POST["firstname"];
        $lastname = $_POST["lastname"];
        $email = $_POST["email"];
        $phone = $_POST["phone"];
        $id = $_SESSION["uid"];

        $sql = "UPDATE Users set email='$email', phone='$phone', firstname='$firstname', lastname='$lastname' where id = '$id'";

        if ($conn->query($sql)) {
            echo "Profile Saved";
        }
    }

}catch (Exception $e){
    echo "Error: " . $e->getMessage();
}

