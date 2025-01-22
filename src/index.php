<?php

$servername = "database"; //will change after new env setup
$username = "user";
$password = "pass";
$dbname = "mcshedual";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo "Connection failed: " . $conn->connect_error;
}

if (isset($_GET['navWindow'])) {
    $navWindow = $_GET['navWindow'];
}

?>
<table>
    <tr>
        <?php if (isset($_GET['uc'])):?>
        <td>
            <?php


            $sql = "SELECT * FROM `users` where id = ".$_GET['uc'].";";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $UserPrivilege = $row['privilege'];

//            will make this all a switch case soon so that im not repeating so much code
            if ($UserPrivilege < 2):
            ?>
            <a href="/?navWindow=addWorker.html">Time Clock</a>
            <a href="/?navWindow=addWorker.html">Schedule</a>
            <a href="/?navWindow=addWorker.html">Calendar</a>
            <a href="/?navWindow=addWorker.html">Request Off</a>
            <a href="/?navWindow=addWorker.html">Email</a> <!--This may not stay a feature, or may become owner only-->
                <?php if ($UserPrivilege == 1): ?>
                <a href="/?navWindow=addWorker.html">Add Worker</a>
                <?php endif;?>

            <?php elseif ($UserPrivilege == 2): ?>
                <a href="/?navWindow=addWorker.html">Time Clock</a>
                <a href="/?navWindow=addWorker.html">Schedule</a>
                <a href="/?navWindow=addWorker.html">Calendar</a>
                <a href="/?navWindow=addWorker.html">Request Off</a>
                <a href="/?navWindow=addWorker.html">Email</a> <!--This may not stay a feature, or may become owner only-->
                <?php if ($row['extendedView'] == 1): ?>
                    <a href="/?navWindow=addWorker.html">Add Worker</a>
                <?php endif;?>
            <?php endif;?>
        </td>
        <?php else: ?>
        <td>
            <a href="/?navWindow=prereq/register.html">Sign up</a>
            <a href="/?navWindow=login.html">Login</a>
        </td>
        <?php endif;?>
    </tr>
</table>

<iframe src="<?= $navWindow ?>" frameborder="1" width="100%" height="90%"></iframe>