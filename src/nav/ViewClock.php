<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
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
echo "<form>
    <table>
        <tr>
            <td>Name</td>
            <td>Date</td>
            <td>In</td>
            <td>Out</td>
            <td>Paid</td>
        </tr>";
$query = "SELECT TimeClock.date as 'date', TimeClock.clockOut as 'clockOut',
          TimeClock.id as 'id', Users.firstname as 'firstname',
          Users.lastname as 'lastname',
          TimeClock.paid as 'paid'
          FROM TimeClock 
          join Users on TimeClock.userID = Users.id
          where Users.id = ".$_SESSION['uid']."
          ORDER BY TimeClock.date DESC;";
$result = $conn->query($query);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $name = $row["firstname"] . " " . $row["lastname"];
        $clockOut = $row['clockOut'] == null ? 'CLOCKED IN' : date('h:i a',strtotime($row['clockOut']));
        if ($row["paid"] == 1) {
            echo "<tr>
              <td>".$name."</td>
              <td>".date('M j',strtotime($row['date']))."</td>
              <td>".date('h:i a',strtotime($row['date']))."</td>
              <td>".$clockOut."</td>
              <td>PAID</td>
              </tr><tr>
                <td><div class='line'></div></td>
        
</tr>";
        }else{
            echo "<tr>
              <td>".$name."</td>
              <td>".date('M j',strtotime($row['date']))."</td>
              <td>".date('h:i a',strtotime($row['date']))."</td>
              <td>".$clockOut."</td>
              <td></td>
              </tr><tr>
                <td><div class='line'></div></td>
        
</tr>";
        }

    }
} else {
    echo "<tr><td>No Data entered</td></tr>";
}
echo "</table></form>";