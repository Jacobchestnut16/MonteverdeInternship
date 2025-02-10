<h1>Event List Editor</h1>
<form action="../../action/addEvent.php">
    <label for="event">Event: </label>
    <input type="text" id="event" name="event" required>
    <button type="submit">Add</button>
</form>

<?php
$servername = "database"; //will change after new env setup
$username = "user";
$password = "pass";
$dbname = "mcshedual";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo "Connection failed: " . $conn->connect_error;
}

$query = "SELECT * FROM EventType";

$result = $conn->query($query);

echo "<table>";

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "
        <tr>
        <td>
        <form action='../../action/updateEvent.php' method=\"post\">
            <input type='text' name='eventValue' value='".$row["eventType"]."' required>
            <input type='hidden' name='eventID' value='".$row["id"]."' required>
            <button type='submit'>Change</button>
        </form>
        </td>
        <td>
        <form action='../../action/deleteEvent.php' method='post'>
            <input type='hidden' name='eventID' value='".$row["id"]."'>
            <input type='hidden' name='eventValue' value='".$row["eventType"]."'>
            <button type='submit'>Delete</button>
        </form>
        </td>
        </tr>
        ";
    }
} else {
    echo "<tr><td>No Data</td></tr>";
}