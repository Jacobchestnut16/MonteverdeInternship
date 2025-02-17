<?php

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
        $username = $_POST["username"];
        $password = $_POST["password"];
        $password = sha1($password);
        $email = $_POST["email"];
        $phone = $_POST["phone"];
        $id = $_POST["id"];

        $sql = "UPDATE Users set username='$username', password='$password', email='$email', phone='$phone', firstname='$firstname', lastname='$lastname' where id = '$id'";

        if ($conn->query($sql)) {
            echo "User has been registered successfully! Please login.";
        }
    }

}catch (Exception $e){
    echo "Error: " . $e->getMessage();
}

function generateSignupCode($userId) {
    // Constants for transformation
    $multiplier = 7411;  // A large prime number
    $offset = 82357;     // Another large offset for obfuscation

    // Generate the code using a mathematical transformation
    $rawCode = ($userId * $multiplier + $offset) % 99999999; // Limit to 8 digits max

    // Pad the code to ensure it's at least 8 digits
    $signupCode = str_pad($rawCode, 8, "0", STR_PAD_LEFT);

    return $signupCode;
}
