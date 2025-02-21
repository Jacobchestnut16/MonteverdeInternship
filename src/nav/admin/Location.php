<h1>Location List Editor</h1>
<form action="../../action/addLocation.php" method="post">
    <label for="eventType">Location: </label>
    <input type="text" id="eventType" name="eventType" required>
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

//$query = "SELECT * FROM EventLocation";
$query = "SELECT EventLocation.location as 'location',EventLocation.color as 'color', EventLocation.id,
       COUNT(Events.locationID) as event_count
FROM EventLocation left join Events on EventLocation.id = Events.locationID
group by EventLocation.id, EventLocation.location
order by event_count DESC";


$result = $conn->query($query);

echo "<table>";

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {

        echo "
        <tr>
        <td>
        <form action='../../action/updateLocation.php' method=\"post\">
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