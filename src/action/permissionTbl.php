<?php
$servername = "database"; //will change after new env setup
$username = "user";
$password = "pass";
$dbname = "mcshedual";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    // echo "Connection failed: " . $conn->connect_error;
}

$lvl = 9;
$protocol = 0;
$title = 1;

foreach ($_POST['rp'] as $permission) {

    if ($lvl > 12){
        $lvl = 9;
        $protocol += 1;
    }


    $query = "UPDATE Permissions SET permission = '$permission'
                   WHERE protocol = '$protocol' 
                   and level = '$lvl'";
    if ($conn->query($query) === TRUE) {
        echo "<p>Updated Permission ................. ".$title."/36</p>";
    }else{
        echo "<p>Error Updating Permission .......... ".$title."/36</p>";
    }
    $title ++;
    $lvl ++;
}