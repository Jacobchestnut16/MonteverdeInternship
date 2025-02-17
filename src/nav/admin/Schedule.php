<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Monteverde Clocks</title>
    <link rel="stylesheet" href="/static/style/dropdown.css">
    <link rel="stylesheet" href="/static/style/calendar.css">
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


if(isset($_GET['month'])){
    $month = $_GET['month'];
    $first_of_month = date('Y-'.$month.'-01');
    $selected_month = date("F, Y", strtotime($first_of_month));
    if ($month > 1) {
        $backArrow = $month - 1;
    } else {
        $backArrow = $month;
    }
    if ($month < 12) {
        $forwardArrow = $month + 1;
    } else {
        $forwardArrow = $month;
    }
echo "<header><table>
            <tr>
                <td><a href='/nav/admin/Schedule.php/?month=".$backArrow."'><</a></td>
                <td class='monthHeader'>
                    <div class='dropdown-container'>
                    <h2><a id='headDate'>".$selected_month."</a></h2>
                        <div class='dropdown'>
                        <a href='/nav/admin/Schedule.php/?month=1'>Jan</a>
                        <a href='/nav/admin/Schedule.php/?month=2'>Feb</a>
                        <a href='/nav/admin/Schedule.php/?month=3'>Mar</a>
                        <a href='/nav/admin/Schedule.php/?month=4'>Apr</a>
                        <a href='/nav/admin/Schedule.php/?month=5'>May</a>
                        <a href='/nav/admin/Schedule.php/?month=6'>Jun</a>
                        <a href='/nav/admin/Schedule.php/?month=7'>Jul</a>
                        <a href='/nav/admin/Schedule.php/?month=8'>Aug</a>
                        <a href='/nav/admin/Schedule.php/?month=9'>Sep</a>
                        <a href='/nav/admin/Schedule.php/?month=10'>Oct</a>
                        <a href='/nav/admin/Schedule.php/?month=11'>Nov</a>
                        <a href='/nav/admin/Schedule.php/?month=12'>Dec</a>
                        </div>
                    </div>
                </td>
                <td><a href='/nav/admin/Schedule.php/?month=".$forwardArrow."'>></a></td>
            </tr>
</table></header>";
}else {
    date_default_timezone_set('America/New_York');
    $month = date('n');
    $current_date = date('j');
    $current_month = date('n');
    $first_of_month = date('Y-m-01');
    $selected_month = date("F, Y");
    //normal navigation logic to select a month
    if ($month > 1) {
        $backArrow = $month - 1;
    } else {
        $backArrow = $month;
    }
    if ($month < 12) {
        $forwardArrow = $month + 1;
    } else {
        $forwardArrow = $month;
    }
    echo "<header><table>
            <tr>
                <td><a href='/nav/admin/Schedule.php/?month=".$backArrow."'><</a></td>
                <td class='monthHeader'>
                    <div class='dropdown-container'>
                    <h2><a id='headDate'>" . $selected_month . "</a></h2>
                        <div class='dropdown'>
                        <a href='/nav/admin/Schedule.php/?month=1'>Jan</a>
                        <a href='/nav/admin/Schedule.php/?month=2'>Feb</a>
                        <a href='/nav/admin/Schedule.php/?month=3'>Mar</a>
                        <a href='/nav/admin/Schedule.php/?month=4'>Apr</a>
                        <a href='/nav/admin/Schedule.php/?month=5'>May</a>
                        <a href='/nav/admin/Schedule.php/?month=6'>Jun</a>
                        <a href='/nav/admin/Schedule.php/?month=7'>Jul</a>
                        <a href='/nav/admin/Schedule.php/?month=8'>Aug</a>
                        <a href='/nav/admin/Schedule.php/?month=9'>Sep</a>
                        <a href='/nav/admin/Schedule.php/?month=10'>Oct</a>
                        <a href='/nav/admin/Schedule.php/?month=11'>Nov</a>
                        <a href='/nav/admin/Schedule.php/?month=12'>Dec</a>
                        </div>
                    </div>
                </td>
                <td><a href='/nav/admin/Schedule.php/?month=".$forwardArrow."'>></a></td>
            </tr>
</table></header>";
}

//SELECT * FROM your_table
//WHERE MONTH(your_datetime_column) = 2;

$query = "SELECT Events.id as 'id', Events.date as 'date', EventType.eventType as 'event',
       EventLocation.location as 'location', Events.workersRequest as 'req', Events.workersAdded as 'added'
FROM Events join EventLocation on Events.locationID = EventLocation.id join EventType on Events.eventTypeID = EventType.id where month(date) = '" . $month . "' order by date asc";

echo "<form action='/action/Schedule.php' method='post'><button type='submit'>Save</button><table><tr><td></td>";

if ($result = $conn->query($query)) {
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<td>".$row['added']."/".$row['req']."</td>";
        }
    }
}
echo "</tr><tr><td></td>";

$ids = [];
$cnt = 0;
if ($result = $conn->query($query)) {
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<td>".$row['location'].", ".$row['event']."</td>";
            $ids[] = $row['id'];
        }
    }
}
echo "</tr><tr><td></td>";

if ($result = $conn->query($query)) {
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<td>".date( 'j' ,strtotime($row['date']))."<br>".date( 'h:m a' ,strtotime($row['date']))."</td>";
            $cnt ++;
        }
    }
}


$query = "Select firstname, lastname, id FROM Users order by firstname asc";



if ($result = $conn->query($query)) {
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row['firstname'] . " " . $row['lastname'] . "</td>";
            for ($i = 0; $i < $cnt; $i++) {
                $anotherQuery = "Select EventUsers.eventID as 'id' FROM Users
                                join EventUsers on Users.id = EventUsers.userID
                                where Users.firstName = '" . $row['firstname'] . "'and EventUsers.eventID = " . $ids[$i] . ";";
                $quickQuery = "Select date from Events where id = " . $ids[$i];
                $qqresult = $conn->query($quickQuery);
                $quickResult = $qqresult->fetch_assoc();
                $lastQuery = "Select * from UsersUnavailableDates where userID = " . $row['id'] . " and DATE(date) = '" .date('Y-m-d',strtotime($quickResult['date']))."';";
                if ($lastQueryResult = $conn->query($lastQuery)) {
                    if ($lastQueryResult->num_rows > 0) {
                        echo "<td>Off ";
                    }else{
                        echo "<td>";
                    }
                }else{
                    echo "<td>";
                }
                if ($checked = $conn->query($anotherQuery)) {
                    if ($checked->num_rows > 0) {
                            echo "<input class='hidden-works' type='hidden' data-id='".$row['id'].$ids[$i]."' name='works[]' value='on'><input class='.checkbox' type='checkbox' data-id='".$row['id'].$ids[$i]."' id='' checked><input type='hidden' name='auth[]' value='".$row['id']."' ><input type='hidden' name='event[]' value='".$ids[$i]."' ></td>";
                    }else {
                        echo "<input class='hidden-works' type='hidden' data-id='".$row['id'].$ids[$i]."' name='works[]' value='off'><input class='.checkbox' type='checkbox' data-id='".$row['id'].$ids[$i]."' id=''><input type='hidden' name='auth[]' value='".$row['id']."' ><input type='hidden' name='event[]' value='".$ids[$i]."' ></td>";

                    }
                }else {
                    echo "<input class='hidden-works' type='hidden' data-id='".$row['id'].$ids[$i]."' name='works[]' value='off'><input class='.checkbox' type='checkbox' data-id='".$row['id'].$ids[$i]."' id=''><input type='hidden' name='auth[]' value='".$row['id']."' ><input type='hidden' name='event[]' value='".$ids[$i]."' > Error Contact Domain-Admin</td>";

                }
            }
            echo "</tr>";
        }
    }
}

echo "</table><input type='hidden' name='month' value='".$month."'></form>";
?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log("Script is running");

        const checkboxes = document.querySelectorAll("input[type='checkbox']")
        checkboxes.forEach(checkbox => {
            console.log('Adding event listener for checkbox:', checkbox);
            checkbox.addEventListener('change', function() {
                const hiddenInput = document.querySelector(`.hidden-works[data-id="${this.dataset.id}"]`);
                if (this.checked) {
                    hiddenInput.value = 'on';
                } else {
                    hiddenInput.value = 'off';
                }
            });
        });
    });


</script>
