<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Monteverde Clocks</title>
    <link rel="stylesheet" href="/static/style/viewEvent.css">
</head>
<body>
<?php

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
$servername = "database"; //will change after new env setup
$username = "user";
$password = "pass";
$dbname = "mcshedual";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo "Connection failed: " . $conn->connect_error;
}

if ($_POST['code'] != generateSignupCode($_POST['id'])) {
    echo "<h1>Wrong code</h1>";
    echo "<h1>Enter the code: " . generateSignupCode($_POST['id']) . " to delete this event.</h1>
<br>
<form action='/action/RemoveEvent.php' method='post'>
<input type='text' name='code' id='code'>
<input type='hidden' name='id' value='" . $_POST['id'] . "'>
<button type='submit'>Delete</button>
</form>";
}

$query = "SELECT Events.name as 'name', Events.Date as 'date',
       Events.notes as 'notes', Events.workersAdded as 'workers', Events.workersRequest as 'maxWorkers',
       EventType.eventType as 'event', EventLocation.location as 'location',
       EventLocation.color as 'color' FROM Events
    join EventLocation on Events.locationID = EventLocation.id 
    join EventType on Events.eventTypeID = EventType.id 
         where Events.id = " . $_POST["id"] . ";";

if ($result = $conn->query($query)) {
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $name = $row["name"];
            $date = date('M,d h:m a',strtotime($row["date"]));
            $dateUnfiltered = $row["date"];
            $notes = $row["notes"];
            $workers = $row["workers"];
            $maxWorkers = $row["maxWorkers"];
            $event = $row["event"];
            $location = $row["location"];
            $color = $row["color"];
        }
    }
}

?>

<div class="line" style="background: <?= $color ?>;"></div>
<div style="background: <?= $color ?>;"><table >
        <tr>
            <td>
                <h1><?= $name == null ? $location : $name ?></h1>
            </td>
        </tr>
        <tr>
            <td><?= $date ?></td>
            <td>Open slots: <?= $workers ?>/<?= $maxWorkers ?></td>
        </tr>
        <tr>
            <td><?= $event ?></td>
            <td>at <?= $location ?></td>
        </tr>
        <tr>
            <td><?= $notes == null ? "No notes" : $notes ?></td>
        </tr>
        <tr><td> hi </td></tr>
        <tr>
            <td>
                <a>Request to work this event</a>
            </td>
        </tr>
        <tr>
            <td>
                <a>Edit Event</a>
            </td>
        </tr>
    </table></div>
<table >
    <tr>
        <td>
            <h1><?= $name == null ? $location : $name ?></h1>
        </td>
    </tr>
    <tr>
        <td><?= $date ?></td>
        <td>Open slots: <?= $workers ?>/<?= $maxWorkers ?></td>
    </tr>
    <tr>
        <td><?= $event ?></td>
        <td>at <?= $location ?></td>
    </tr>
    <tr>
        <td><?= $notes == null ? "No notes" : $notes ?></td>
    </tr>
    <tr><td><br></td></tr>
    <?php
    if ($_POST["code"] != generateSignupCode($_POST["id"])) {
        echo "
    <tr>
        <td>
            <a href='/nav/ViewEvent.php/?id=".$_POST['id']."'>Cancel</a>
        </td>
    </tr>
</table>
    
    ";
    }else {
        echo "
    <tr>
        <td>
        <form action='/action/EventCreator.php' method='post'>
                <input type='hidden' name='name' value='" . $name . "'>
                <input type='hidden' name='dt' value='" . $dateUnfiltered . "'>
                <input type='hidden' name='loc' value='" . $location . "'>
                <input type='hidden' name='evn' value='". $event ."'>
                <input type='hidden' name='requests' value='". $maxWorkers ."'>
                <input type='hidden' name='notes' value='". $notes ."'>
                <button type='submit'>Wait Re-add</button>
        </td>
    </tr>
</table>
    
    ";
        $query = "DELETE FROM EventUsers WHERE eventID = '".$_POST["id"]."'";
        if ($conn->query($query) === TRUE) {
            $query = "DELETE FROM Events WHERE id = " . $_POST["id"];
            if ($conn->query($query) === TRUE) {
                echo "<h1>Event deleted</h1>";
            }else{
                echo "<h1>Error Failed to delete: " . $conn->error . "</h1>";
            }
        }else{
            echo "<h1>Error Failed to delete: " . $conn->error . "</h1>";
        }
    }
    ?>

