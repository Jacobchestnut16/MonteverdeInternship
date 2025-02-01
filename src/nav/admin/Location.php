<form action="../../action/addEvent.php">
    <label for="event">Location: </label>
    <input type="text" id="event" name="event" required>
    <label for="eventColor">Color: </label>
    <input type="color" name="eventColor" id="eventColor">
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

$query = "SELECT * FROM EventLocation";

$result = $conn->query($query);

echo "<table>";

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "
        <tr>
        <td>
        <form action='' method=\"post\">
            <input type='text' name='eventValue' value='".$row["location"]."' required>
            <input type='color' name='eventColor' value='".$row["color"]."' required>
            <input type='hidden' name='eventID' value='".$row["id"]."' required>
            <button type='submit'>Change</button>
        </form>
        </td>
        <td>
        <form action=''>
            <input type='hidden' name='eventID' value='".$row["id"]."'>
            <button type='submit'>Delete</button>
        </form>
        </td>
        </tr>
        ";
    }
} else {
    echo "<tr><td>No Data</td></tr>";
}