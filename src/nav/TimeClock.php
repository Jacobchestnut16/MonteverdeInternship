<?php
session_start();
$servername = "database"; //will change after new env setup
$username = "user";
$password = "pass";
$dbname = "mcshedual";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    // echo "Connection failed: " . $conn->connect_error;
}

$query = "SELECT * FROM TimeClock where userID = ".$_SESSION['uid']." AND 
                        clockOut is null 
                        order by date desc limit 1";
$result = $conn->query($query);
if ($result->num_rows > 0) {
    echo "<form action='/action/timeClock/ClockOut.php' method='POST'>
    <table>
    <tr>
    <td><button type='submit'>Clock Out</button></td>
    </tr>
    </table></form><h1>Forgot to clock out?</h1>";
    include "MissedPunch.php";

}else{
    echo "<form action='/action/timeClock/ClockIn.php' method='POST'><table>
    <tr>
    <td><button type='submit'>Clock in</button></td>
    </tr>
    </table></form><h1>View Passed Punches</h1>";
    include "ViewClock.php";
}
