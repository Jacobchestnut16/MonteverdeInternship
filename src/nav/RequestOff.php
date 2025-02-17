<?php
session_start();
?>
<form action="/action/RequestOff.php" method="post">
    <table>
        <tr>
            <td>
                <label for="date-out">From</label>
                <br>
                <input type="date" name="dateo" id="date-out">
            </td>
            <td>
                <label for="date-in">To</label>
                <br>
                <input type="date" name="datei" id="date-in">
            </td>
        </tr>
        <tr>
            <td>
                <button type="submit">Request</button>
            </td>
        </tr>
    </table>
</form>
<?php

$servername = "database"; //will change after new env setup
$username = "user";
$password = "pass";
$dbname = "mcshedual";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    // echo "Connection failed: " . $conn->connect_error;
}

echo "<form action='/action/RemoveRequestOff.php' method='post'><table><tr><td>Date</td><td>Select</td><td><button type='submit'>Remove</button></td></tr>";
$query = "SELECT * FROM UsersUnavailableDates WHERE `userID` = $_SESSION[uid]";
if ($result = $conn->query($query)){
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>".date('M j, Y',strtotime($row['date']))."</td>
                    <td>
                    <input type='checkbox' name='dates[]' value='".$row['id']."'>
                    </td>
                    </tr>";
        }
    } else{
        echo "<tr><td>No days requested off</td></tr>";
    }
}else{
    echo "<tr><td>Error:" . $conn->error."</td></tr>";
}
echo "</table></form>";
