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
    <link rel="manifest" href="/manifest.json">
</head>
<body>
<button id="installBtn" style="display: none;">Install PWA</button>
<script>
    if ("serviceWorker" in navigator) {
        navigator.serviceWorker.register("/service-worker.js")
            .then(() => console.log("Service Worker Registered"))
            .catch((error) => console.log("Service Worker Registration Failed:", error));
    }
    let deferredPrompt;
    window.addEventListener("beforeinstallprompt", (event) => {
        event.preventDefault();
        deferredPrompt = event;

        document.getElementById("installBtn").style.display = "block";

        document.getElementById("installBtn").addEventListener("click", () => {
            deferredPrompt.prompt();
            deferredPrompt.userChoice.then((choiceResult) => {
                if (choiceResult.outcome === "accepted") {
                    console.log("User installed the PWA");
                }
                deferredPrompt = null;
            });
        });
    });

</script>

<?php if (isset($_SESSION['uid'])) {
            if (isset($_GET['navWindow'])) {
                $navWindow = $_GET['navWindow'];
            }

            echo "
<div class='nav'>
    <table class='phone'>
        <tr><td><a href='/?navWindow=/nav/Calendar.php'>&#128198;</a></td>
            <td><a href='/?navWindow=nav/Calendar.php/?tree=1'>&#128214;</a></td>
            <td><a href='/?navWindow=nav/TimeClock.php'>&#128349;</a></td>
            <td><p>&#128229;</p></td>
            <td><a href='/?navWindow=nav/admin/Profile.php'>&#9776;</a></td>
        </tr>
    </table>
</div>
";
            } else{
    if (isset($_GET['navWindow'])) {
        $navWindow = '/prereq/register.html';
    }
    echo "
<div class='nav'>
    <table class='phone'>
    <tr>
        <td>
            <a href='/?navWindow=/prereq/register.html'>Sign up</a>
            <a href='login.html'>Login</a>
        </td>
                </tr>
    </table>
</div>
        ";
            }

?>
<div class="nav">
<table class="comp">
    <tr>
        <?php if (isset($_SESSION['uid'])) {
            if (isset($_GET['navWindow'])) {
                $navWindow = $_GET['navWindow'];
            }
            $sql = "SELECT * FROM `Users` where id = " . $_SESSION['uid'] . ";";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $UserPrivilege = $row['privilege'];

            $privileges = [];
            $query = "SELECT * FROM Permissions WHERE level = " . $UserPrivilege . ";";
            $result = $conn->query($query);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $privileges[] = $row['permission'];
                }
            }
            echo "
            <td>
                 <div class='dropdown-container'>
                      <a href='/?navWindow=nav/admin/workerProfiles.php'>Crew</a>
                      <div class='dropdown'>
                          <table>";
            if ($privileges[3] == 1)
                echo "<tr><td><a href='/?navWindow=nav/admin/addWorker.html' title='Add new worker profile'>Add Worker</a></td></tr>";
            echo "<tr><td><a href='/?navWindow=nav/admin/workerProfiles.php' title='View, Edit, Remove crew'>Worker Profile</a></td></tr>";
            if ($privileges[4] == 1)
                echo "<tr><td><a href='/?navWindow=nav/admin/Schedule.php' title='Schedule users'>Schedule</a></td></tr>
                      <tr><td><a href='/?navWindow=nav/admin/RequestHandler.php' title='Schedule users'>View Requests</a></td></tr>";
            if ($privileges[8] == 1)
                echo "<tr><td><a href='/?navWindow=nav/admin/PermissionTabel.php' title='Users Permission Table'>Permissions</a></td></tr>";
            echo "</table></div></div></td>";


            echo "
                      <td>
                          <div class='dropdown-container'>
                              <a href='/?navWindow=nav/TimeClock.php'>Time Clock</a>
                              <div class='dropdown'>
                                  <table>
                                  <tr><td><a href='/?navWindow=nav/TimeClock.php'>Time Clock</a></td></tr>";
            if ($privileges[7] == 1)
                echo "<tr><td><a href='/?navWindow=nav/admin/TimeClock.php'>View Clock</a></td></tr>";
            else
                echo "<tr><td><a href='/?navWindow=nav/ViewClock.php'>View Clock</a></td></tr>";
            echo "
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
                              <a href='/?navWindow=nav/Calendar.php/?tree=1'>Schedule</a>
                              <div class='dropdown'>
                                  <table>";
            if ($privileges[4] == 1)
                echo "<tr><td><a href='/?navWindow=nav/admin/Schedule.php'>Create</a></td></tr>";
            echo "
                                      <tr><td><a href='/?navWindow=nav/Calendar.php/?tree=1'>Schedule</a></td></tr>
                                      <tr><td><a href='/?navWindow=nav/RequestOff.php'>Request Off</a></td></tr>
                                      <tr><td><a href='/?navWindow=nav/Calendar.html'>Request Days</a></td></tr>
                                  </table>
                              </div>
                          </div>
                      </td>
                      <td><a href='/?navWindow=nav/Email.html'>Mail</a> <!--This may not stay a feature, or may become owner only--></td>
                      <td>
                         <div class='dropdown-container'>
                              <a href='/?navWindow=nav/admin/Profile.php'>Profile</a>
                              <div class='dropdown'>
                                  <table>
                                      <tr><td><a href='/?navWindow=nav/admin/Profile.php'>Profile</a></td></tr>
                                      <tr><td><a href='/?navWindow=nav/admin/ResetPassword.php'>Reset Password</a></td></tr>
                                      <tr><td><a href='/action/logout.php'>Logout</a></td></tr>
                                  </table>
                              </div>
                          </div>
                      </td>
                    ";

        }else{
            if (isset($_GET['navWindow'])) {
                $navWindow = '/prereq/register.html';
            }
        echo "
        <td>
            <a href='/?navWindow=/prereq/register.html'>Sign up</a>
            <a href='login.html'>Login</a>
        </td>
        ";
        }
 ?>
    </tr>
</table>
</div>

<iframe src="<?= $navWindow ?>" frameborder="1"></iframe>
</body>
</html>