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


        CREATE TABLE IF NOT EXISTS Users (
        id INT NOT NULL AUTO_INCREMENT,
        username VARCHAR(100) NOT NULL,
        password VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL,
        phone VARCHAR(15) NOT NULL,
        firstname VARCHAR(100) NOT NULL,
        lastname VARCHAR(100) NOT NULL,
        privilege int NOT NULL,
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
        
        CREATE TABLE IF NOT EXISTS Events (
        id INT NOT NULL AUTO_INCREMENT,
        name VARCHAR(100),
        date DATETIME NOT NULL,
        eventTypeID int NOT NULL,
        locationID int NOT NULL,
        notes VARCHAR(899),
        workersRequest int NOT NULL,
        workersAdded int NOT NULL,
        PRIMARY KEY (id),
        FOREIGN KEY (eventTypeID) REFERENCES EventType (id),
        FOREIGN KEY (locationID) REFERENCES EventLocation (id));
        
        
        CREATE TABLE IF NOT EXISTS UserEventRequest (
        id INT NOT NULL AUTO_INCREMENT,
        eventID INT NOT NULL,
        userID INT NOT NULL,
        approved TINYINT(1) NOT NULL DEFAULT 0,
        PRIMARY KEY (id),
        FOREIGN KEY (eventID) REFERENCES Events (id),
        FOREIGN KEY (userID) REFERENCES Users (id),
        UNIQUE (eventID, userID));


        CREATE TABLE IF NOT EXISTS EventUsers (
        id INT NOT NULL AUTO_INCREMENT,
        eventID INT NOT NULL,
        userID INT NOT NULL,
        PRIMARY KEY (id),
        FOREIGN KEY (eventID) REFERENCES Events (id),
        FOREIGN KEY (userID) REFERENCES Users (id),
        UNIQUE (eventID, userID)
        );
        
        CREATE TABLE IF NOT EXISTS UsersUnavailableDates (
        id INT NOT NULL AUTO_INCREMENT,
        userID INT NOT NULL,
        date DATETIME NOT NULL,
        PRIMARY KEY (id),
        FOREIGN KEY (userID) REFERENCES Users (id),
        UNIQUE (userID, date)
        );
        CREATE TABLE IF NOT EXISTS TimeClock (
        id INT NOT NULL AUTO_INCREMENT,
        date DATETIME NOT NULL,
        clockOut DATETIME,
        paid TINYINT(1) NOT NULL DEFAULT 0,
        userID INT NOT NULL,
        PRIMARY KEY (id),
        FOREIGN KEY (userID) REFERENCES Users (id)
        );

        CREATE TABLE IF NOT EXISTS MissedPunch (
        id INT NOT NULL AUTO_INCREMENT,
        timeClockID INT NOT NULL,
        date DATETIME NOT NULL,
        clockOut DATETIME NOT NULL,
        PRIMARY KEY (id),
        FOREIGN KEY (timeClockID) REFERENCES TimeClock (id)
        );
        
        ";

if ($conn->multi_query($sql) === TRUE) {
    echo "Database tables created successfully";
    include 'AdminSetup.html';
} else{
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>



