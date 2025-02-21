<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
</head>
<body>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Signup</title>
    <link rel="stylesheet" href="/static/style/login.css">
</head>
<body>
<?php

$id = $_SESSION['uid'];

$servername = "database"; //will change after new env setup
$username = "user";
$password = "pass";
$dbname = "mcshedual";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo "Connection failed: " . $conn->connect_error;
}

$query = "SELECT * FROM Users WHERE id=$id";
$result = $conn->query($query);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $firstname = $row["firstname"];
        $lastname = $row["lastname"];
        $email = $row["email"];
        $phone = $row["phone"];
        $username = $row["username"];
    }
}


?>

<form action="/action/EditProfile.php" method="post">
    <table>
        <tr>
            <td>
                <label for="firstname">First name:</label>
                <input type="text" name="firstname" id="firstname" required onchange="verifyCompletion()" value="<?= $firstname; ?>">
            </td>
            <td>
                <label for="lastname">Last name: </label>
                <input type="text" name="lastname" id="lastname" required onchange="verifyCompletion()"  value="<?= $lastname; ?>">
            </td>
        </tr>
        <tr>
            <td>
                <label for="username">Username:</label>
                <p><?= $username; ?></p>
            </td>
            <td>
                <label for="email">Email: </label>
                <input type="email" name="email" id="email" required onchange="verifyCompletion()" value="<?= $email; ?>">
            </td>
        </tr>
        <tr>
            <td>
                <label for="phone">Phone number:</label>
                <input type="tel" name="phone" id="phone" required onchange="verifyCompletion()" value="<?= $phone; ?>">
            </td>
        </tr>
        <tr>
            <td>
                <a href="/nav/admin/ResetPassword.php">Reset Password</a>
            </td>
        </tr>
        <tr>
            <td>
                <button id="submit" class="hide" type="submit">save</button>
            </td>
        </tr>
    </table>
</form>

<script>

    function verifyCompletion() {
        if (document.getElementById('phone') != null && document.getElementById('email') != null
            && document.getElementById('firstname') != null && document.getElementById('lastname') != null
        ){
            document.getElementById('submit').className = 'show';
        } else{
            document.getElementById('submit').className = 'hide';
        }
    }

</script>



</body>
</html>

</body>
</html>