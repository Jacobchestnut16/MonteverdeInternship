<?php
if (session_status() == PHP_SESSION_NONE) {
session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Monteverde Clocks</title>
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

$query = "SELECT Events.name as 'name', Events.Date as 'date',
       Events.notes as 'notes', Events.workersAdded as 'workers', Events.workersRequest as 'maxWorkers',
       EventType.eventType as 'event', EventLocation.location as 'location',
       EventLocation.color as 'color' FROM Events
    join EventLocation on Events.locationID = EventLocation.id 
    join EventType on Events.eventTypeID = EventType.id 
         where Events.id = " . $_GET["id"] . ";";

if ($result = $conn->query($query)) {
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $name = $row["name"] == null ? $row["location"] : $row["name"];
            $date = date('M,d h:i a',strtotime($row["date"]));
            $notes = $row["notes"];
            $workers = $row["workers"];
            $maxWorkers = $row["maxWorkers"];
            $event = $row["event"];
            $location = $row["location"];
            $color = $row["color"];
        }
    }
}
$requested = false;
$working = false;
$query = "SELECT * from UserEventRequest where eventID = " . $_GET["id"] . " and userID = ".$_SESSION["uid"].";";
if ($result = $conn->query($query)) {
    if ($result->num_rows > 0) {
        $requested = true;
    }
}
$query = "SELECT * from EventUsers where eventID = " . $_GET["id"] . " and userID = ".$_SESSION["uid"].";";
if ($result = $conn->query($query)) {
    if ($result->num_rows > 0) {
        $working = true;
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
    <tr>
        <td>
            <?php

            if (!$requested && !$working) {
                echo "<form action='/action/RequestEvent.php' method='post'>
                <input type='hidden' name='events[]' value='".$_GET['id']."'>
            <button type='submit'>Request to work event</button>
            </form>";
            }
            if ($working) {
                echo "<form action='/action/DropShift.php' method='post'>
                <input type='hidden' name='events[]' value='".$_GET['id']."'>
            <button type='submit'>Drop Shift</button>
            </form>";
            }
            ?>
        </td>
    </tr>
    <tr>
        <td>
            <?php

            if ($_SESSION['privileges'][6] == 1)
            echo "
            <a href='/nav/admin/EditEvent.php/?id=".$_GET['id']."'>Edit Event</a>
            
            ";
            ?>
        </td>
    </tr>
    <tr>
        <td>
            <?php

            if ($_SESSION['privileges'][6] == 1 && $_SESSION['privileges'][5] == 1)
                echo "
            <a href='/nav/admin/RemoveEvent.php/?id=".$_GET['id']."'>DELETE Event</a>
            
            ";
            ?>
        </td>
    </tr>
</table>


</body>
</html>
