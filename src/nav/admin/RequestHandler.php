<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Monteverde Clocks</title>
    <link rel="stylesheet" href="/static/style/viewEvent.css">
    <link rel="stylesheet" href="/static/style/viewEvent.css">
</head>
<body>
<?php
$servername = "database"; //will change after new env setup
$username = "user";
$password = "pass";
$dbname = "mcshedual";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo "Connection failed: " . $conn->connect_error;
}

echo "<table><tr><td>Name</td><td>Event</td><td>Location</td><td>Date</td><td>Deny</td><td>Approve</td></tr>";

$query = "SELECT UserEventRequest.id as 'id', Events.id as 'eid', Users.id as 'uid',
            Events.name as 'eventName', Users.firstname as 'firstname', Users.lastname as 'lastname',
            EventLocation.location as 'location', Events.date as 'date'
        FROM UserEventRequest 
        join Events on Events.id = UserEventRequest.eventID 
        join Users on Users.id = UserEventRequest.userID
        join EventLocation on EventLocation.id = Events.locationID
        where UserEventRequest.approved = 0";
$result = $conn->query($query);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $event = $row["eventName"];
        $name = $row["firstname"]." ".$row["lastname"];
        $location = $row["location"];
        $date = date('M,j h:m a',strtotime($row["date"]));
        echo "<tr><td>".$name."</td><td>".$event."</td><td>".$location."</td><td>".$date."</td>
                <td>
                    <form action='/action/handleREquests/Deny.php' method='post'>
                    <input type='hidden' name='uID' value='".$row['uid']."'>
                    <input type='hidden' name='eID' value='".$row['eid']."'>
                    <input type='hidden' name='id' value='".$row['id']."'>
                    <button type='submit'>Deny</button>
                    </form>
                </td>   
                <td>
                    <form action='/action/handleREquests/Approve.php' method='post'>
                    <input type='hidden' name='uID' value='".$row['uid']."'>
                    <input type='hidden' name='eID' value='".$row['eid']."'>
                    <input type='hidden' name='id' value='".$row['id']."'>
                    <button type='submit'>Approve</button>
                    </form>
                </td>
        </tr><tr>
                <td><div class='line'></div></td>
        
</tr>";
    }
}