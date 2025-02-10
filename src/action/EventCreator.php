<?php

//Get post elements
$name = $_POST['name'];
$datetime = $_POST['dt'];
$loc = $_POST['loc'];
$env = $_POST['evn'];
$notes = $_POST['notes'];

//Check if elements are in db
$servername = "database"; //will change after new env setup
$username = "user";
$password = "pass";
$dbname = "mcshedual";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo "Connection failed: " . $conn->connect_error;
}

$locationID = 0;
$eventID = 0;

//waterfall
//if location isn't there go to ../admin/pseudoLocation.php/?loc=$loc&env=$env
$query = "SELECT ID FROM EventLocation where location='$loc'";
if ($result = $conn->query($query)) {
    echo "Location Check ................... PASS";
    $locationID = $result->fetch_assoc()['ID'];

} else {
    echo "Location Check ................... FAIL";
    echo "Updating Location Table ......... BEGIN";
    $query = "INSERT EventLocation (location, color) values ('$loc', '#000000');SELECT ID FROM EventLocation where location='$loc';";
    if ($result = $conn->multi_query($query)) {
        echo "Location Table Update ......... SUCCESS";
        $locationID = $result->fetch_assoc()['ID'];

    } else{
        echo "Location Table Update ............ FAIL";
    }
}
//elseif event isn't there go to ../admin/pseudoEvent.php/?env=$env&loc=$loc
$query = "SELECT ID FROM EventType where eventType='$env'";
if ($result = $conn->query($query)) {
    echo "Event-type Check ................. PASS";
    $eventID = $result->fetch_assoc()['ID'];
} else {
    echo "Event-type Check ................. FAIL";
    echo "Updating Event-type Table ....... BEGIN";
    $query = "INSERT EventLocation (location, color) values ('$loc', '#000000'); SELECT ID FROM EventType where eventType='$env'";
    if ($result = $conn->multi_query($query)) {
        echo "Event-type Table Update ....... SUCCESS";
        $eventID = $result->fetch_assoc()['ID'];

    } else{
        echo "Event-type Table Update .......... FAIL";
    }
}

//else add the event to the database
//include calendar.php/?month=$month

$query = "INSERT INTO Events (name, date, eventTypeID, locationID, notes) VALUES ('$name', '$datetime', '$eventID', '$locationID', '$notes');)";
if ($result = $conn->query($query)) {
    echo "<h1>Event Created Successfully</h1>";
}else{
    echo "<h1>Event Created Failed: " . $conn->error . "</h1>";
}

