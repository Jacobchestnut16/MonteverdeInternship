<?php
ini_set('session.cookie_lifetime', 86400); // Keep session alive for 1 day
ini_set('session.gc_maxlifetime', 86400);
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
    $sql = "SELECT * FROM `Users` where username = '".$_POST['username']."';";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    if ($result->num_rows <= 0) {
        echo "Invalid username or password";
        echo "<br>";
        include '../login.html'; //uses the base file to display most of the contents


    }
    $encrypted_password = sha1($_POST["password"]);
    if ($row['password'] == $encrypted_password) {
        $_SESSION['uid'] = $row['id'];
        $sql = "SELECT * FROM `Users` where id = ".$_SESSION['uid'].";";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $UserPrivilege = $row['privilege'];

        $privileges = [];
        $query = "SELECT * FROM Permissions WHERE level = ".$UserPrivilege.";";
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $privileges[] = $row['permission'];
            }
        }

        $_SESSION['privileges'] = $privileges;


        header('Location: /');
        exit();

    }else{
        echo "Invalid username or password";
        echo "<br>";
        include '../login.html'; //uses the base file to display most of the contents

    }
}catch (Exception $e){
    echo "Error: " . $e->getMessage();
    echo "<br>";
    include '../login.html'; //uses the base file to display most of the contents


}

