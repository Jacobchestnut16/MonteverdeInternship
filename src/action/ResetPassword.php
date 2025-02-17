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

$query = "Select * from Users where id = ".$_SESSION['uid']." and password = '".sha1($_POST['old'])."'";
$result = $conn->query($query);
if ($result->num_rows > 0) {
    $query = "UPDATE Users set password = '".sha1($_POST['password'])."' where id = ".$_SESSION['uid'];
}else{
    echo "<h1>Sorry incorrect password/code</h1>";
    echo "
    <!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <title>Signup</title>
    <link rel='stylesheet' href='/static/style/login.css'>
</head>
<body>

<form action='/action/ResetPassword.php' method='post'>
    <table>
        <tr>
            <td>
                <label for='old'>Current Password</label>
                <br>
                <input type='password' name='old' id='old' onchange='verifyCompletion()'>
            </td>
        </tr>
        <tr>
            <td>
                <label for='password'>New Password</label>
                <br>
                <input type='password' name='password' id='password' onchange='verifyPasswords(); verifyCompletion()'>
            </td>
            <td>
                <label for='verifyPassword'>Confirm Password</label>
                <br>
                <input type='password' name='verifyPassword' id='verifyPassword' onchange='verifyPasswords(); verifyCompletion()'>
            </td>
        </tr>
        <tr>
            <td>
                <button type='submit' id='submit' class='hide'>Set New Password</button>
            </td>
        </tr>
    </table>
</form>

<script>

    function verifyPasswords() {
        console.log('starting evaluation');
        if (document.getElementById('password').value === document.getElementById('verifyPassword').value){
            document.getElementById('password').className = 'correct';
            document.getElementById('verifyPassword').className = 'correct';
        } else{
            document.getElementById('password').className = 'incorrect';
            document.getElementById('verifyPassword').className = 'incorrect';
        }
    }

    function verifyCompletion() {
        if (document.getElementById('password').value != null && document.getElementById('verifyPassword').value != null
            && document.getElementById('old') != null && document.getElementById('password').className === 'correct'
        ){
            document.getElementById('submit').className = 'show';
        } else{
            document.getElementById('submit').className = 'hide';
        }
    }
</script>
    ";
}