<?php
ini_set('session.cookie_lifetime', 86400); // Keep session alive for 1 day
ini_set('session.gc_maxlifetime', 86400);
session_start();

$servername = "database"; //will change after new env setup
$username = "user";
$password = "pass";
$dbname = "mcshedual";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    // echo "Connection failed: " . $conn->connect_error;
}

try {
    $sql = "SELECT * FROM `Users`;";
    $result = $conn->query($sql);

} catch (Exception $e) {
    //go to sql_setup/create_tables.php
    $conn->close();
    header('Location: sql_setup/create_tables.php');
    exit();

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Monteverde Clocks</title>
    <link rel="stylesheet" href="static/style/dropdown.css">
    <link rel="stylesheet" href="static/style/index.css">
</head>
<body>
<table class="nav">
    <tr>
        <?php if (isset($_SESSION['uid'])):?>

            <?php
            if (isset($_GET['navWindow'])) {
                $navWindow = $_GET['navWindow'];
            }
            $sql = "SELECT * FROM `Users` where id = ".$_SESSION['uid'].";";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $UserPrivilege = $row['privilege'];
            //$UserPrivilege = 11;


            switch (true) {
                case ($UserPrivilege > 9):
                    if ($UserPrivilege > 11) {
                    echo "
                                <td>
                                     <div class='dropdown-container'>
                                          <a>Crew</a>
                                          <div class='dropdown'>
                                              <table>
                                                  <tr><td><a href='/?navWindow=nav/admin/addWorker.html' title='Add new worker profile'>Add Worker</a></td></tr>
                                                  <tr><td><a href='/?navWindow=nav/admin/workerProfiles.php' title='View, Edit, Remove crew'>Worker Profile</a></td></tr>
                                                  <tr><td><a href='/?navWindow=nav/admin/Schedule.php' title='Schedule users'>Schedule</a></td></tr>
                                                  <tr><td><a href='/?navWindow=nav/admin/RequestHandler.php' title='Schedule users'>View Requests</a></td></tr>
                                              </table>
                                          </div>
                                      </div>
                                </td>
                                <td><div class='dropdown-container'>
                                    <a>Event</a>
                                    <div class='dropdown'>
                                        <table>
                                            <tr><td><a href='/?navWindow=nav/admin/EventCreator.php' title='Create an event on the calendar'>Create Event</a></td></tr>
                                            <tr><td><a href='/?navWindow=nav/admin/Event.php' title='Edit the list of known events'>Events-Type List Editor</a></td></tr>
                                            <tr><td><a href='/?navWindow=nav/admin/Location.php' title='Edit the list of know locations'>Locations List Editor</a></td></tr>
                                        </table>
                                    </div>
                                </div></td>
                        ";
                    }
                    elseif ($UserPrivilege == 11) {
                        echo "
                                <td>
                                          <a href='/?navWindow=nav/admin/workerProfiles.php' title='View, Edit, Lock, Reset Passwords'>Crew</a>
                                </td>
                                <td><div class='dropdown-container'>
                                    <a>Event</a>
                                    <div class='dropdown'>
                                        <table>
                                            <tr><td><a href='/?navWindow=nav/admin/EventCreator.php' title='Create an event on the calendar'>Create Event</a></td></tr>
                                            <tr><td><a href='/?navWindow=nav/admin/Event.php' title='Edit the list of known events'>Events-Type List Editor</a></td></tr>
                                            <tr><td><a href='/?navWindow=nav/admin/Location.php' title='Edit the list of know locations'>Locations List Editor</a></td></tr>
                                        </table>
                                    </div>
                                </div></td>
                        ";
                    }
                if ($UserPrivilege == 10) {
                    echo "
                                <td>
                                          <a href='/?navWindow=nav/admin/workerProfiles.php' title='View, Reset Passwords'>Crew</a>
                                </td>
                                <td><div class='dropdown-container'>
                                    <a>Event</a>
                                    <div class='dropdown'>
                                        <table>
                                            <tr><td><a href='/?navWindow=nav/admin/EventCreator.php' title='Create an event on the calendar'>Create Event</a></td></tr>
                                            <tr><td><a href='/?navWindow=nav/admin/Event.php' title='Edit the list of known events'>Events-Type List Editor</a></td></tr>
                                            <tr><td><a href='/?navWindow=nav/admin/Location.php' title='Edit the list of know locations'>Locations List Editor</a></td></tr>
                                        </table>
                                    </div>
                                </div></td>
                        ";
                }
                case $UserPrivilege >= 9:
                    echo "
                      <td>
                          <div class='dropdown-container'>
                              <a>Time Clock</a>
                              <div class='dropdown'>
                                  <table>
                                  <tr><td><a href='/?navWindow=nav/TimeClock.php'>Time Clock</a></td></tr>
                                  <tr><td><a href='/?navWindow=nav/admin/TimeClock.php'>View Clock</a></td></tr>
                                  <tr><td><a href='/?navWindow=nav/MissedPunch.php'>Missed punch form</a></td></tr>
                                  </table>
                              </div>
                          </div>
                      </td>
                      <td>
                          <div class='dropdown-container'>
                              <a href='/?navWindow=nav/Calendar.php'>Calendar</a>
                          </div>
                      </td>
                      <td>
                          <div class='dropdown-container'>
                              <a>Schedule</a>
                              <div class='dropdown'>
                                  <table>";
                    if ($UserPrivilege > 01) {
                    echo "<tr><td><a href='/?navWindow=nav/admin/Schedule.php'>Create</a></td></tr>";
                    }
                    echo "
                                      <tr><td><a href='/?navWindow=nav/Calendar.php/?tree=1'>Schedule</a></td></tr>
                                      <tr><td><a href='/?navWindow=nav/Calendar.html'>Request Days</a></td></tr>
                                      <tr><td><a href='/?navWindow=nav/RequestOff.php'>Request Off</a></td></tr>
                                  </table>
                              </div>
                          </div>
                      </td>
                      <td><a href='/?navWindow=nav/Email.html'>Mail</a> <!--This may not stay a feature, or may become owner only--></td>
                      <td>
                         <div class='dropdown-container'>
                              <a>Profile</a>
                              <div class='dropdown'>
                                  <table>
                                      <tr><td><a href='/?navWindow=nav/admin/Profile.php'>Profile</a></td></tr>
                                      <tr><td><a href='/?navWindow=nav/admin/ResetPassword.php'>Reset Passord</a></td></tr>
                                      <tr><td><a href='/action/logout.php'>Logout</a></td></tr>
                                  </table>
                              </div>
                          </div>
                      </td>
                    ";
            }

            ?>
        <?php else: ?>
        <td>
            <a href="/?navWindow=prereq/register.html">Sign up</a>
            <a href="login.html">Login</a>
        </td>
        <?php endif;?>
    </tr>
</table>

<iframe src="<?= $navWindow ?>" frameborder="1"></iframe>
</body>
</html>