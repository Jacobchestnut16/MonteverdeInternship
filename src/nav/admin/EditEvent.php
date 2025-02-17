<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Monteverde Clocks</title>
    <link rel="stylesheet" href="/static/style/edit.css">
    <link rel="stylesheet" href="/static/style/dropdown.css">
    <link rel="stylesheet" href="/static/style/creator.css">
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

$query = "SELECT Events.name as 'name', Events.notes as 'notes', Events.date as 'date', Events.workersRequest as 'workersRequest', Events.workersAdded as 'workersAdded',
          EventLocation.location as 'location', EventType.eventType as 'eventType' FROM Events join EventLocation on EventLocation.id = Events.locationID
         join EventType on EventType.id = Events.eventTypeID WHERE Events.id = " . $_GET["id"] . ";";
$result = $conn->query($query);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $name = $row["name"];
    $notes = $row["notes"];
    $date = $row["date"];
    $requests = $row["workersRequest"];
    $workersAdded = $row["workersAdded"];
    $location = $row["location"];
    $eventType = $row["eventType"];
}

?>

<form action="/action/UpdateEventCreator.php" method="post">
    <table>
        <tr>
            <td>
                <label for="name">Name</label>
                <br>
                <input type="text" name="name" id="name" value="<?= $name ?>">
            </td>
            <td>
                <label for="td">Time</label>
                <br>
                <input type="datetime-local" name="dt" id="dt"  value="<?= $date ?>" required>
            </td>
        </tr>
        <tr>
            <td>
                <label for="loc">Location</label>
                <br>
                <div class="dropdown-container">
                    <input type="text" name="loc" id="loc" value="<?= $location ?>" required>
                    <div class="dropdown">
                        <table>
                            <?php
                            try {
                                $query = "SELECT location FROM EventLocation";

                                $result = $conn->query($query);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr><td><a onclick='setLoc("."\"".$row['location']."\"".")'>" . $row['location'] . "</a></td></tr>";
                                    }
                                } else {
                                    echo "<tr><td>No event types found</td></tr>";
                                }
                            } catch (Exception $e) {
                                echo "<tr><td>".$e."</td></tr>";
                            }
                            ?>
                        </table>
                    </div>
                </div>

            </td>
            <td>
                <label for="evn">Event Type</label>
                <br>
                <div class="dropdown-container">
                    <input type="text" name="evn" id="evn" value="<?= $eventType ?>" required>
                    <div class="dropdown">
                        <table>
                            <?php
                            try{
                                $query = "SELECT eventType FROM EventType";

                                $result = $conn->query($query);

                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo "<tr><td><a onclick='setEnv("."\"".$row['eventType']."\"".")'>".$row['eventType']."</a></td></tr>";
                                    }
                                }
                                else{
                                    echo "<tr><td>No event types found</td></tr>";
                                }
                            } catch (Exception $e) {
                                echo "<tr><td>".$e."</td></tr>";
                            }
                            ?>
                        </table>
                    </div>
                </div>

            </td>
            </td>
        </tr>
        <tr>
            <td>
                <label for="requests">Open Request Max</label>
                <br>
                <input type="number" name="requests" id="requests" value="<?= $requests ?>">
            </td>
        </tr>
        <tr>
            <td>
                <label for="notes">Notes</label>
                <br>
                <input type="text" name="notes" id="notes"  value="<?= $notes ?>">
            </td>
        </tr>
        <tr>
            <td>
                <input type="hidden" name="id" id="id"  value="<?= $_GET['id'] ?>">
                <input type="hidden" name="workersAdded" id="workersAdded"  value="<?= $workersAdded ?>">
                <button type="submit">Save Event</button>
            </td>
        </tr>
    </table>
</form>

<script>
    function setLoc(loc) {
        document.getElementById('loc').value = loc;
    }
    function setEnv(evn) {
        document.getElementById('evn').value = evn;
    }
</script>

<?php
