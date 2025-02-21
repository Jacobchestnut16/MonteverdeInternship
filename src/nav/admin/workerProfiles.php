<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Monteverde Clocks</title>
    <link rel="stylesheet" href="../../static/style/profile.css">
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

function generateSignupCode($userId) {
    // Constants for transformation
    $multiplier = 7411;  // A large prime number
    $offset = 82357;     // Another large offset for obfuscation

    // Generate the code using a mathematical transformation
    $rawCode = ($userId * $multiplier + $offset) % 99999999; // Limit to 8 digits max

    // Pad the code to ensure it's at least 8 digits
    $signupCode = str_pad($rawCode, 8, "0", STR_PAD_LEFT);

    return $signupCode;
}
?>

<div>
<div>
    <?php

    $query = "SELECT * FROM `Users`";

    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $name = $row["firstname"]." ".$row["lastname"];
            $initials = substr($row['firstname'], 0, 1).substr($row['lastname'], 0, 1);
            $privilege = $row["privilege"] == 9 ? "Crew" : ($row["privilege"] == 10 ?
                "Crew-Management" : ($row["privilege"] == 11 ? "Management":
                    ($row["privilege"] == 12 ? "Domain-Management" : "Domain Admin")));
            echo "<div class='card'>
                    <table>
                        <tr class='head'>
                            <td>
                                <img src='' alt='".$initials."'>
                                <h4>".$name."</h4>
                            </td>
                        </tr>
                        <tr>
                            <td>Level: ".$privilege."</td>
                        </tr>
                        <tr>
                            <td>Phone: ".$row['phone']."</td>
                        </tr>
                        <tr>
                            <td>Email: ".$row['email']."</td>
                        </tr>
                    </table>
                    
                    <div class='dropdown''>
                        <table>
                            <tr>
                                <td>
                                    <a>Chat</a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <a>Edit Profile</a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <a href='reset.php/?uprc=".generateSignupCode($row['id'])."'>Reset Password</a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <a>Delete Member</a>
                                </td>
                            </tr>
                        </table>
                    </div>
                    
                    </div>";
        }
    }
    ?>


</div>
</div>


<script>
    document.getElementsByName()
</script>

</body>
</html>
