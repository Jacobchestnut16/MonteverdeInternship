<?php

$servername = "database"; //will change after new env setup
$username = "user";
$password = "pass";
$dbname = "mcshedual";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo "Connection failed: " . $conn->connect_error;
}


$code = $_POST['code'];

if ($code === '75214831'){
    include 'signup.html';

}else {

    try {
        $sql = "SELECT * FROM `Users` where MOD((id * 7411 + 82357), 99999999) = $code";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        if ($result->num_rows <= 0) {
            echo "<!-- Additional content -->
<div id='error-message' style='color: red;'>
    <p>Invalid code.</p>
</div>";
            echo "<br>";
            include 'register.html'; //uses the base file to display most of the contents


        } else {
            if (!isset($row['firstname']))
                $row['firstname'] = '';
            if (!isset($row['lastname']))
                $row['lastname'] = '';
            header('Location: configure.php/?firstname='.$row['firstname'].'&lastname='.$row['lastname'].'&id='.$row['id'].'');
            exit();
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }

}

?>
