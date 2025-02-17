<?php

//Get post elements
$name = $_POST['name'];
$datetime = $_POST['dt'];
$loc = $_POST['loc'];
$env = $_POST['evn'];
$notes = $_POST['notes'];
$requests = $_POST['requests'];
$workersAdded = $_POST['workersAdded'];
$id = $_POST['id'];

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
$query = "SELECT id FROM EventLocation where location='$loc'";
if ($result = $conn->query($query)) {
    if ($result->num_rows > 0) {
        echo "<p>Location Check ................... PASS</p>";
        $data = $result->fetch_assoc();
        $locationID = $data['id'];

    }else {
        echo "<p>Location Check ................... FAIL</p>";
        echo "<p>Updating Location Table ......... BEGIN</p>";
        $query = "INSERT EventLocation (location, color) values ('$loc', '#000000');";
        if ($result = $conn->query($query)) {
            echo "<p>Location Table Update ......... SUCCESS</p>";
            $result = $conn->query("SELECT id FROM EventLocation where location='$loc';");
            $data = $result->fetch_assoc();
            $locationID = $data['id'];

        } else {
            echo "<p>Location Table Update ............ FAIL</p>";
        }
    }

} else {
    echo "<p>Location Table Load .............. FAIL</p>";
}
//elseif event isn't there go to ../admin/pseudoEvent.php/?env=$env&loc=$loc
$query = "SELECT id FROM EventType where eventType='$env'";
if ($result = $conn->query($query)) {
    if ($result->num_rows > 0) {
        echo "<p>Event-type Check ................. PASS</p>";
        $data = $result->fetch_assoc();
        $eventID = $data['id'];
    } else{
        echo "<p>Event-type Check ................. FAIL</p>";
        echo "<p>Updating Event-type Table ....... BEGIN</p>";
        $query = "INSERT EventType (eventType) values ('$env');";
        if ($result = $conn->query($query)) {
            echo "<p>Event-type Table Update ....... SUCCESS</p>";
            $result = $conn->query("SELECT id FROM EventType where eventType='$env';");
            $data = $result->fetch_assoc();
            $eventID = $data['id'];

        } else{
            echo "<p>Event-type Table Update .......... FAIL</p>";
        }
    }
} else {
    echo "<p>Event-type Table Load ............ FAIL</p>";
}

//else add the event to the database
//include calendar.php/?month=$month

$query = "UPDATE Events set name = '$name', date = '$datetime', eventTypeID = $eventID,
                  locationID = $locationID, notes = '$notes', workersRequest = $requests, workersAdded = $workersAdded
                    where id = $id;";
if ($result = $conn->query($query)) {
    echo "<a href='/nav/ViewEvent.php/?id=".$id."'>Back to View Event</a>";
}else{
    echo "<h1>Event Update Failed: " . $conn->error . "</h1>";
}

