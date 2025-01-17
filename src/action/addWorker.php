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
        $privilege = $_POST["privilege"];

        $sql = "INSERT INTO users (username, password, email, phone, fristname, lastname, privilege, extendedVeiw) VALUES ('','','','',$firstname,$lastname,$privilege,0)";
        if ($conn->query($sql) === TRUE) {
            echo "User created successfully";
            $findUserID = "SELECT id FROM users order by id desc limit 1";
            $result = $conn->query($findUserID);
            $row = $result->fetch_assoc();
            $id = $row["id"];
            echo "Sign up code is: " . generateSignupCode($id) . "<br><comment>Ensure you give this code to the new worker!</comment>";
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
