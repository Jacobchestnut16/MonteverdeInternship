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
    // echo "Connection failed: " . $conn->connect_error;
}
echo "<form action='/action/timeClock/PayOut.php' method='post'>
    <table>
        <tr>
            <td>Name</td>
            <td>Date</td>
            <td>In</td>
            <td>Out</td>
            <td>Hours</td>
            <td>Paid</td>
            <td><button type='submit'>Save</button></td>
        </tr>";
$query = "SELECT TimeClock.date as 'date', TimeClock.clockOut as 'clockOut',
          TimeClock.id as 'id', Users.firstname as 'firstname',
          Users.lastname as 'lastname', TimeClock.paid as 'paid'
          FROM TimeClock join Users on TimeClock.userID = Users.id ORDER BY TimeClock.paid DESC ,TimeClock.date DESC, Users.firstname ASC;";
$result = $conn->query($query);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $name = $row["firstname"] . " " . $row["lastname"];
        $query = "SELECT * FROM MissedPunch WHERE timeClockID = " . $row["id"];
        $clockOut = $row['clockOut'] == null ? 'CLOCKED IN' : date('h:i a',strtotime($row['clockOut']));
        if ($clockOut != 'CLOCKED IN') {
            $clockOut = date('h:i a', strtotime($row['clockOut']));

            // Convert to DateTime objects
            $clockOutTime = new DateTime($row['clockOut']);
            $clockInTime = new DateTime($row['date']);

            // Calculate the difference in hours
            $interval = $clockInTime->diff($clockOutTime);
            $hours = $interval->h + ($interval->i / 60);
        }else{
            $hours = "Clocked in";
        }
        $result2 = $conn->query($query);
        if ($result2->num_rows > 0) {
            while($row2 = $result2->fetch_assoc()) {
                $clockOutTime = new DateTime($row2['clockOut']);
                $clockInTime = new DateTime($row2['date']);

                // Calculate the difference in hours
                $interval = $clockInTime->diff($clockOutTime);
                $hours = $interval->h + ($interval->i / 60);
                if ($row["paid"] == 1) {
                    echo "<tr>
              <td>" . $name . "</td>
              <td>" . date('M j', strtotime($row['date'])) . "</td>
              <td>" . date('h:i a', strtotime($row['date'])) . "</td>
              <td>" . $clockOut . "</td>
              </tr>";
                    echo "<tr>
              <td>" . $name . "</td>
              <td>" . date('M j', strtotime($row2['date'])) . "</td>
              <td>" . date('h:i a', strtotime($row2['date'])) . "</td>
              <td>" . date('h:i a', strtotime($row2['clockOut'])) . "</td>
              <td>".$hours."</td>
              <td><input type='checkbox' name='paid' id='paid' checked></td>
              </tr><tr>
                <td><div class='line'></div></td>
        
</tr>";
                } else {
                    echo "<tr>
              <td>" . $name . "</td>
              <td>" . date('M j', strtotime($row['date'])) . "</td>
              <td>" . date('h:i a', strtotime($row['date'])) . "</td>
              <td>" . $clockOut . "</td>
              </tr>";
                    echo "<tr>
              <td>" . $name . "</td>
              <td>" . date('M j', strtotime($row2['date'])) . "</td>
              <td>" . date('h:i a', strtotime($row2['date'])) . "</td>
              <td>" . date('h:i a', strtotime($row2['clockOut'])) . "</td>
              <td>".$hours."</td>
              <td><input type='checkbox' name='paid[]' id='paid' value='".$row['id']."'></td>
              </tr><tr>
                <td><div class='line'></div></td>
        
</tr>";
                }
            }
        }else {
            if ($row["paid"] == 1) {
                echo "<tr>
              <td>" . $name . "</td>
              <td>" . date('M j', strtotime($row['date'])) . "</td>
              <td>" . date('h:i a', strtotime($row['date'])) . "</td>
              <td>" . $clockOut . "</td>
              <td><input type='checkbox' name='paid' id='paid' checked></td>
              </tr>";
            } else {
                echo "<tr>
              <td>" . $name . "</td>
              <td>" . date('M j', strtotime($row['date'])) . "</td>
              <td>" . date('h:i a', strtotime($row['date'])) . "</td>
              <td>" . $clockOut . "</td>
              <td>".$hours."</td>
              <td><input type='checkbox' name='paid[]' id='paid' value='".$row['id']."'></td>
              </tr><tr>
                <td><div class='line'></div></td>
        
</tr>";
            }
        }

    }
} else {
    echo "<tr><td>No Data entered</td></tr>";
}
echo "</table></form>";