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
    $sql = "SELECT * FROM `users` where username = $_POST[username]";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    if ($result->num_rows <= 0) {
        echo "Invalid username or password";
        echo "<br>";
        echo "<iframe src='../login.html'></iframe>";
    }
    $encrypted_password = sha1($_POST["password"]);
    if ($row['password'] == $encrypted_password) {
        session_start();
        $_SESSION['uID'] = $row['uID'];
        header('Location: index.php/?uid='.$row['uID']);
        exit();

    }else{
        echo "Invalid username or password";
        echo "<br>";
        echo "<iframe src='../login.html'></iframe>";
    }
}catch (Exception $e){
    echo "Error: " . $e->getMessage();
    echo "<br>";
    echo "<iframe src='../login.html'></iframe>";
}

