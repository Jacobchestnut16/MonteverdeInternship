<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Monteverde Clocks</title>
    <link rel="stylesheet" href="static/style/dropdown.css">
    <link rel="stylesheet" href="static/style/index.css">
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

try {
    $sql = "SELECT * FROM `Users`;";
    $result = $conn->query($sql);
} catch (Exception $e) {
    //go to sql_setup/create_tables.php
    echo 'moving';
    conn.exit();
    header('Location: /sql_setup/create_tables.php');
    exit();

}

if (isset($_GET['navWindow'])) {
    $navWindow = $_GET['navWindow'];
}

?>
<table class="nav">
    <tr>
        <?php if (isset($_GET['uc'])):?>
            <?php


            $sql = "SELECT * FROM `Users` where id = ".$_GET['uc'].";";
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
                                                  <tr><td><a href='/?navWindow=nav/admin/addWorker.html&uc=" . $_GET['uc'] . "' title='Add new worker profile'>Add Worker</a></td></tr>
                                                  <tr><td><a href='/?navWindow=nav/admin/workerProfiles.php&uc=" . $_GET['uc'] . "' title='View, Edit, Remove crew'>Worker Profile</a></td></tr>
                                              </table>
                                          </div>
                                      </div>
                                </td>
                                <td><div class='dropdown-container'>
                                    <a>Event</a>
                                    <div class='dropdown'>
                                        <table>
                                            <tr><td><a href='/?navWindow=nav/admin/EventCreator.php&uc=" . $_GET['uc'] . "' title='Create an event on the calendar'>Create Event</a></td></tr>
                                            <tr><td><a href='/?navWindow=nav/admin/Event.php&uc=" . $_GET['uc'] . "' title='Edit the list of known events'>Events List Editor</a></td></tr>
                                            <tr><td><a href='/?navWindow=nav/admin/Location.php&uc=" . $_GET['uc'] . "' title='Edit the list of know locations'>Locations List Editor</a></td></tr>
                                        </table>
                                    </div>
                                </div></td>
                        ";
                    }
                    elseif ($UserPrivilege == 11) {
                        echo "
                                <td>
                                          <a href='/?navWindow=nav/admin/workerProfiles.php&uc=" . $_GET['uc'] . "' title='View, Edit, Lock, Reset Passwords'>Crew</a>
                                </td>
                                <td><div class='dropdown-container'>
                                    <a>Event</a>
                                    <div class='dropdown'>
                                        <table>
                                            <tr><td><a href='/?navWindow=nav/admin/EventCreator.php&uc=" . $_GET['uc'] . "' title='Create an event on the calendar'>Create Event</a></td></tr>
                                            <tr><td><a href='/?navWindow=nav/admin/Event.php&uc=" . $_GET['uc'] . "' title='Edit the list of known events'>Events List Editor</a></td></tr>
                                            <tr><td><a href='/?navWindow=nav/admin/Location.php&uc=" . $_GET['uc'] . "' title='Edit the list of know locations'>Locations List Editor</a></td></tr>
                                        </table>
                                    </div>
                                </div></td>
                        ";
                    }
                if ($UserPrivilege == 10) {
                    echo "
                                <td>
                                          <a href='/?navWindow=nav/admin/workerProfiles.php&uc=" . $_GET['uc'] . "' title='View, Reset Passwords'>Crew</a>
                                </td>
                                <td><div class='dropdown-container'>
                                    <a>Event</a>
                                    <div class='dropdown'>
                                        <table>
                                            <tr><td><a href='/?navWindow=nav/admin/EventCreator.php&uc=" . $_GET['uc'] . "' title='Create an event on the calendar'>Create Event</a></td></tr>
                                            <tr><td><a href='/?navWindow=nav/admin/Event.php&uc=" . $_GET['uc'] . "' title='Edit the list of known events'>Events List Editor</a></td></tr>
                                            <tr><td><a href='/?navWindow=nav/admin/Location.php&uc=" . $_GET['uc'] . "' title='Edit the list of know locations'>Locations List Editor</a></td></tr>
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
                                  <tr><td><a href='/?navWindow=nav/TimeClock.php&uc=".$_GET['uc']."'>Time Clock</a></td></tr>
                                  <tr><td><a href='/?navWindow=nav/MissedPunch.php&uc=" . $_GET['uc'] . "'>Missed punch form</a></td></tr>
                                  </table>
                              </div>
                          </div>
                      </td>
                      <td>
                          <div class='dropdown-container'>
                              <a href='/?navWindow=nav/Calendar.php&uc=" . $_GET['uc'] . "'>Calendar</a>
                          </div>
                      </td>
                      <td>
                          <div class='dropdown-container'>
                              <a>Schedule</a>
                              <div class='dropdown'>
                                  <table>
                                      <tr><td><a href='/?navWindow=nav/Calendar.php&tree=1&uc=" . $_GET['uc'] . "'>Schedule</a></td></tr>
                                      <tr><td><a href='/?navWindow=nav/Calendar.html&uc=" . $_GET['uc'] . "'>Request Days</a></td></tr>
                                      <tr><td><a href='/?navWindow=nav/RequestOff.html&uc=" . $_GET['uc'] . "'>Request Off</a></td></tr>
                                  </table>
                              </div>
                          </div>
                      </td>
                      <td><a href='/?navWindow=nav/Email.html&uc=" . $_GET['uc'] . "'>Mail</a> <!--This may not stay a feature, or may become owner only--></td>
                      <td>
                         <div class='dropdown-container'>
                              <a>Profile</a>
                              <div class='dropdown'>
                                  <table>
                                      <tr><td><a href='/?navWindow=nav/Schedule.html&uc=" . $_GET['uc'] . "'>Profile</a></td></tr>
                                      <tr><td><a href='/?navWindow=nav/Calendar.html&uc=" . $_GET['uc'] . "'>Reset Passord</a></td></tr>
                                      <tr><td><a href='/'>Logout</a></td></tr>
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
            <a href="/?navWindow=login.html">Login</a>
        </td>
        <?php endif;?>
    </tr>
</table>

<iframe src="<?= $navWindow ?>" frameborder="1"></iframe>
</body>
</html>