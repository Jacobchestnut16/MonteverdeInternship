<?php
session_start();

foreach ($_POST['events'] as $id) {
    $servername = "database"; //will change after new env setup
    $username = "user";
    $password = "pass";
    $dbname = "mcshedual";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        echo "Connection failed: " . $conn->connect_error;
    }

    $query = "DELETE FROM EventUsers WHERE eventID = '$id' and userID = " . $_SESSION['uid'];
    if ($conn->query($query) === TRUE) {
        echo "<p>Submitted drop shift</p>";
    }else{
        echo "Error: " . $query . "<br>" . $conn->error;
    }
}

