<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Monteverde Clocks</title>
    <link rel="stylesheet" href="../../static/style/dropdown.css">
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

?>

<form action="../../action/EventCreator.php" method="post">
    <table>
        <tr>
            <td>
                <label for="name">Name</label>
                <br>
                <input type="text" name="name" id="name">
            </td>
            <td>
                <label for="td">Time</label>
                <br>
                <input type="datetime-local" name="dt" id="dt" required>
            </td>
        </tr>
        <tr>
            <td>
                <label for="loc">Location</label>
                <br>
                <div class="dropdown-container">
                    <input type="text" name="loc" id="loc" required>
                    <div class="dropdown">
                        <table>
                            <?php
                            try {
                                $query = "SELECT location FROM Location";

                                $result = $conn->query($query);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr><td><a onclick='setLoc(\"" . $row['location'] . "\")'>" . $row['location'] . "</a></td></tr>";
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
                    <input type="text" name="evn" id="evn" required>
                    <div class="dropdown">
                        <table>
                            <?php
                            try{
                                $query = "SELECT eventType FROM EventType";

                                $result = $conn->query($query);

                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo "<tr><td><a onclick='setEnv(\"" . $row['eventType'] . "\")'>".$row['eventType']."</a></td></tr>";
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
                <label for="notes">Notes</label>
                <br>
                <input type="text" name="notes" id="notes">
            </td>
        </tr>
        <tr>
            <td>
                <button type="submit">Add Event</button>
            </td>
        </tr>
    </table>
</form>

<script>
    function setLoc(loc) {
        document.getElementById('loc').innerText = loc;
    }
    function setEnv(evn) {
        document.getElementById('evn').innerText = evn;
    }
</script>

<?php
