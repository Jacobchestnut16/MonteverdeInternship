<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Monteverde Clocks</title>
    <link rel="stylesheet" href="/static/style/dropdown.css">
    <link rel="stylesheet" href="/static/style/calendar.css">
</head>
<body>
<tabel>
    <tr>
        <td><a onclick="week()">Week</a></td>
        <td><a onclick="month()">Month</a></td>
    </tr>
</tabel>
<?php
date_default_timezone_set('America/New_York');
$month = date('n');
$current_date = date('j');
$current_month = date('n');
$first_of_month = date('Y-m-01');
$selected_month = date("F, Y");
$start_of_month = date('w', strtotime($first_of_month));
$days_in_month = date('t', strtotime($first_of_month));
$month_end = date('Y-m-t', strtotime($first_of_month));
$end_of_month = date('w', strtotime($month_end));

$end_of_previous_month = date('t', strtotime('-1 month'));

if(isset($_GET['month'])){
    $month = $_GET['month'];
    $first_of_month = date('Y-'.$month.'-01');
    $selected_month = date("F, Y", strtotime($first_of_month));
    $start_of_month = date('w', strtotime($first_of_month));
    $days_in_month = date('t', strtotime($first_of_month));
    $month_end = date('Y-m-t', strtotime($first_of_month));
    $end_of_month = date('w', strtotime($month_end));

    $end_of_previous_month = date('t', strtotime($first_of_month.' -1 month'));

    //Unsure why normal logic doesn't work when the iframe is called to move to a new window  but regardless easy fix
    // just set the href to the base folder and file  ##not src since it calls it at index
    echo "<header><table>
            <tr>
                <td><a><</a></td>
                <td class='monthHeader'>
                    <div class='dropdown-container'>
                    <h2><a id='headDate'>".$selected_month."</a></h2>
                        <div class='dropdown'>
                        <a href='/nav/Calendar.php/?month=1'>Jan</a>
                        <a href='/nav/Calendar.php/?month=2'>Feb</a>
                        <a href='/nav/Calendar.php/?month=3'>Mar</a>
                        <a href='/nav/Calendar.php/?month=4'>Apr</a>
                        <a href='/nav/Calendar.php/?month=5'>May</a>
                        <a href='/nav/Calendar.php/?month=6'>Jun</a>
                        <a href='/nav/Calendar.php/?month=7'>Jul</a>
                        <a href='/nav/Calendar.php/?month=8'>Aug</a>
                        <a href='/nav/Calendar.php/?month=9'>Sep</a>
                        <a href='/nav/Calendar.php/?month=10'>Oct</a>
                        <a href='/nav/Calendar.php/?month=11'>Nov</a>
                        <a href='/nav/Calendar.php/?month=12'>Dec</a>
                        </div>
                    </div>
                </td>
                <td><a>></a></td>
            </tr>
</table></header>";
}else {

    //normal navigation logic to select a month
    echo "<header><table>
            <tr>
                <td><a><</a></td>
                <td class='monthHeader'>
                    <div class='dropdown-container'>
                    <h2><a id='headDate'>" . $selected_month . "</a></h2>
                        <div class='dropdown'>
                        <a href='Calendar.php/?month=1'>Jan</a>
                        <a href='Calendar.php/?month=2'>Feb</a>
                        <a href='Calendar.php/?month=3'>Mar</a>
                        <a href='Calendar.php/?month=4'>Apr</a>
                        <a href='Calendar.php/?month=5'>May</a>
                        <a href='Calendar.php/?month=6'>Jun</a>
                        <a href='Calendar.php/?month=7'>Jul</a>
                        <a href='Calendar.php/?month=8'>Aug</a>
                        <a href='Calendar.php/?month=9'>Sep</a>
                        <a href='Calendar.php/?month=10'>Oct</a>
                        <a href='Calendar.php/?month=11'>Nov</a>
                        <a href='Calendar.php/?month=12'>Dec</a>
                        </div>
                    </div>
                </td>
                <td><a>></a></td>
            </tr>
</table></header>";
}

echo "<table>
<tr class='weekDays'><td>Sunday</td><td>Monday</td><td>Tuesday</td><td>Wednesday</td><td>Thursday</td><td>Friday</td><td>Saturday</td>
</tr></table>";
echo "<div id='month' class='show'><table class='days'><tr>";
if ($start_of_month != 0) {
    $start_of_week = $end_of_previous_month - $start_of_month + 1;
    for ($i = 0; $i < $start_of_month; $i++) {
        echo "<td class='surroundingMonth'>" . ($i + $start_of_week) . "</td>";
    }
}

$event = [2,10,11,15,22,22];

for ($i = 1; $i <= $days_in_month; $i++) {
    if ($i == $current_date && $month == $current_month) {
        if (in_array($i, $event)) {echo "<td class='currentDay'><p class='date'>" . $i . "</p><div class='event-container'>";
            for ($j = 0; $j < count($event); $j++) {
                if ($event[$j] == $i) {
                    echo "<div class='event'></div>";
                }
            }
            echo "</div></td>";
        }else
            echo "<td class='currentDay'><p class='date'>" . $i . "</p></td>";
    } else {
        if (in_array($i, $event)) {
            echo "<td><p class='date'>" . $i . "</p><div class='event-container'>";
            for ($j = 0; $j < count($event); $j++) {
                if ($event[$j] == $i) {
                    echo "<div class='event'></div>";
                }
            }
            echo "</div></td>";
        }else
            echo "<td><p class='date'>$i</p></td>";
    }
    if (($i + $start_of_month) % 7 == 0) {
        echo "</tr><tr>";
    }
}
if ($end_of_month != 6) {
    for ($i = 1; ($end_of_month + $i) <= 6; $i++) {
        echo "<td class='surroundingMonth'>" . $i . "</td>";
    }
}
echo "</tr></table></div>";


echo "<div id='week' class='hide'><table class='week'><tr>";
$current_week = date('w');
if ($current_week > 0) {
    for ($i = $current_date - $current_week; $i < $current_date; $i++) {
        echo "<td><p class='date'>$i</p></td>";
    }
}
echo "<td class='currentDay'><p class='date'>" . $current_date . "</p></td>";

if ($current_week != 6) {
    $exceeded = false;
    for ($i = $current_date + 1; ($current_week+($i - $current_date)) <=6; $i++) {
        if ($i <= $days_in_month) {
            echo "<td><p class='date'>$i</p></td>";
        }else{
            $exceeded = true;
            break;
        }
    }
    if ($exceeded){
        if ($end_of_month != 6) {
            for ($i = 1; ($end_of_month + $i) <= 6; $i++) {
                echo "<td class='surroundingMonth'>" . $i . "</td>";
            }
        }
    }
}
echo "</tr></table></div>";

?>


<script>
    <?php
        $current_date = date('F, Y');
    ?>

    currentM = "<?= $current_date ?>";
    function week(){
        splice = currentM;
        document.getElementById('headDate').innerText = splice;
        document.getElementById('week').className = 'show';
        document.getElementById('month').className = 'hide';
    }
    function month(){
        document.getElementById('week').className = 'hide';
        document.getElementById('month').className = 'show';
    }
</script>

</body>
</html>


