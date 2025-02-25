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
    <link rel="stylesheet" href="../static/style/login.css">
</head>
<body>

<form action="/action/register.php" method="post">
    <table>
        <tr>
            <td>
                <label for="firstname">First name:</label>
                <input type="text" name="firstname" id="firstname" required onchange="verifyCompletion()" value="<?= $_GET['firstname']; ?>">
            </td>
            <td>
                <label for="lastname">Last name: </label>
                <input type="text" name="lastname" id="lastname" required onchange="verifyCompletion()"  value="<?= $_GET['lastname']; ?>">
            </td>
        </tr>
        <tr>
            <td>
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" required onchange="verifyCompletion()">
            </td>
            <td>
                <label for="email">Email: </label>
                <input type="email" name="email" id="email" required onchange="verifyCompletion()">
            </td>
        </tr>
        <tr>
            <td>
                <label for="phone">Phone number:</label>
                <input type="tel" name="phone" id="phone" required onchange="verifyCompletion()">
            </td>
        </tr>
        <tr>
            <td>
                <label for="password">Password:</label>
                <input type="text" name="password" id="password" required onchange="verifyPasswords(); verifyCompletion()">
            </td>
            <td>
                <label for="verifyPassword">Password:</label>
                <input type="text" name="verifyPassword" id="verifyPassword" required onchange="verifyPasswords(); verifyCompletion()">
            </td>
        </tr>
        <tr>
            <td>
                <input type="hidden" name="id" id="id" value="<?= $_GET['id']; ?>">
                <button id="submit" class="hide" type="submit">Register</button>
            </td>
        </tr>
    </table>
</form>

<script>

    function verifyPasswords() {
        console.log('starting evaluation');
        if (document.getElementById('password').value === document.getElementById('verifyPassword').value){
            document.getElementById('password').className = "correct";
            document.getElementById('verifyPassword').className = "correct";
        } else{
            document.getElementById('password').className = "incorrect";
            document.getElementById('verifyPassword').className = "incorrect";
        }
    }

    function verifyCompletion() {
        if (document.getElementById('password').value != null && document.getElementById('username').value != null
            && document.getElementById('phone') != null && document.getElementById('email') != null
            && document.getElementById('verifyPassword') != null && document.getElementById('firstname') != null && document.getElementById('lastname') != null && document.getElementById('password').className === 'correct'
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