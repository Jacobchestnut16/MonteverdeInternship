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
        endDate DATETIME NOT NULL,
        eventTypeID int,
        locationID int,
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
        
        drop table Permissions;
        CREATE TABLE IF NOT EXISTS Permissions (
        id INT NOT NULL AUTO_INCREMENT,
        protocol INT NOT NULL,
        level INT NOT NULL,
        permission INT NOT NULL,
        PRIMARY KEY (id)
        );
        
        INSERT INTO Permissions (protocol, level, permission) VALUES (0,9,0); 
        INSERT INTO Permissions (protocol, level, permission) VALUES (1,9,0); 
        INSERT INTO Permissions (protocol, level, permission) VALUES (2,9,0); 
        INSERT INTO Permissions (protocol, level, permission) VALUES (3,9,0); 
        INSERT INTO Permissions (protocol, level, permission) VALUES (4,9,0); 
        INSERT INTO Permissions (protocol, level, permission) VALUES (5,9,0); 
        INSERT INTO Permissions (protocol, level, permission) VALUES (6,9,0); 
        INSERT INTO Permissions (protocol, level, permission) VALUES (7,9,0); 
        INSERT INTO Permissions (protocol, level, permission) VALUES (8,9,0); 
        
        INSERT INTO Permissions (protocol, level, permission) VALUES (0,10,1);
        INSERT INTO Permissions (protocol, level, permission) VALUES (1,10,0);
        INSERT INTO Permissions (protocol, level, permission) VALUES (2,10,0);
        INSERT INTO Permissions (protocol, level, permission) VALUES (3,10,0);
        INSERT INTO Permissions (protocol, level, permission) VALUES (4,10,0);
        INSERT INTO Permissions (protocol, level, permission) VALUES (5,10,0);
        INSERT INTO Permissions (protocol, level, permission) VALUES (6,10,0);
        INSERT INTO Permissions (protocol, level, permission) VALUES (7,10,0);
        INSERT INTO Permissions (protocol, level, permission) VALUES (8,10,0);

        INSERT INTO Permissions (protocol, level, permission) VALUES (0,11,1);
        INSERT INTO Permissions (protocol, level, permission) VALUES (1,11,1);
        INSERT INTO Permissions (protocol, level, permission) VALUES (2,11,0);
        INSERT INTO Permissions (protocol, level, permission) VALUES (3,11,1);
        INSERT INTO Permissions (protocol, level, permission) VALUES (4,11,1);
        INSERT INTO Permissions (protocol, level, permission) VALUES (5,11,1);
        INSERT INTO Permissions (protocol, level, permission) VALUES (6,11,1);
        INSERT INTO Permissions (protocol, level, permission) VALUES (7,11,0);
        INSERT INTO Permissions (protocol, level, permission) VALUES (8,11,0);

        INSERT INTO Permissions (protocol, level, permission) VALUES (0,12,1);
        INSERT INTO Permissions (protocol, level, permission) VALUES (1,12,1);
        INSERT INTO Permissions (protocol, level, permission) VALUES (2,12,1);
        INSERT INTO Permissions (protocol, level, permission) VALUES (3,12,1);
        INSERT INTO Permissions (protocol, level, permission) VALUES (4,12,1);
        INSERT INTO Permissions (protocol, level, permission) VALUES (5,12,1);
        INSERT INTO Permissions (protocol, level, permission) VALUES (6,12,1);
        INSERT INTO Permissions (protocol, level, permission) VALUES (7,12,1);
        INSERT INTO Permissions (protocol, level, permission) VALUES (8,12,1);

        INSERT INTO Permissions (protocol, level, permission) VALUES (0,13,1);
        INSERT INTO Permissions (protocol, level, permission) VALUES (1,13,1);
        INSERT INTO Permissions (protocol, level, permission) VALUES (2,13,1);
        INSERT INTO Permissions (protocol, level, permission) VALUES (3,13,1);
        INSERT INTO Permissions (protocol, level, permission) VALUES (4,13,1);
        INSERT INTO Permissions (protocol, level, permission) VALUES (5,13,1);
        INSERT INTO Permissions (protocol, level, permission) VALUES (6,13,1);
        INSERT INTO Permissions (protocol, level, permission) VALUES (7,13,1);
        INSERT INTO Permissions (protocol, level, permission) VALUES (8,13,1);
        
        
        ";

if ($conn->multi_query($sql) === TRUE) {
    echo "Database tables created successfully";
    include 'AdminSetup.html';
} else{
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>



