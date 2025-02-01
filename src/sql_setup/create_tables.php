<?php

$servername = "database"; //will change after new env setup
$username = "user";
$password = "pass";
$dbname = "mcshedual";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo "Connection failed: " . $conn->connect_error;
}

$sql = "CREATE DATABASE IF NOT EXISTS $dbname;

        CREATE TABLE IF NOT EXISTS users (
        id INT NOT NULL AUTO_INCREMENT,
        username VARCHAR(100) NOT NULL,
        password VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL,
        phone VARCHAR(15) NOT NULL,
        firstname VARCHAR(100) NOT NULL,
        lastname VARCHAR(100) NOT NULL,
        privilege int NOT NULL,
        extendedView int NOT NULL,
        PRIMARY KEY (id));
        
        CREATE TABLE IF NOT EXISTS EventLocation (
        id INT NOT NULL AUTO_INCREMENT,
        location varchar(100) NOT NULL,
        color varchar(100) NOT NULL,
        PRIMARY KEY (id));
        
        CREATE TABLE IF NOT EXISTS EventType (
        id INT NOT NULL AUTO_INCREMENT,
        eventType varchar(100) NOT NULL,
        PRIMARY KEY (id));
        
        CREATE TABLE IF NOT EXISTS events (
        id INT NOT NULL AUTO_INCREMENT,
        name VARCHAR(100) NOT NULL,
        date DATETIME NOT NULL,
        eventTypeID int NOT NULL,
        locationID int NOT NULL),
        PRIMARY KEY (id),
        FOREIGN KEY (eventTypeID) REFERENCES EventType (id),
        FOREIGN KEY (locationID) REFERENCES EventLocation (id));
        
        CREATE TABLE IF NOT EXISTS EventUsers (
        id INT NOT NULL AUTO_INCREMENT,
        eventID INT NOT NULL,
        userID INT NOT NULL,
        PRIMARY KEY (id),
        FOREIGN KEY (eventID) REFERENCES events (id),
        FOREIGN KEY (userID) REFERENCES users (id));
        ";
?>
<form action="">

</form>
