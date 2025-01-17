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

}

try{
    $sql = "SELECT * FROM `users` where MOD((id * 7411 + 82357), 99999999) = $code";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    if ($result->num_rows <= 0) {
        echo "<!-- Additional content -->
<div id='error-message' style='color: red;'>
    <p>Invalid code.</p>
</div>";
        echo "<br>";
        include 'register.html'; //uses the base file to display most of the contents


    }else{
        echo "
        
        <script>
        // Create a form
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = 'configure.php'; // Replace with the target site

        // Add POST elements
        const input1 = document.createElement('input');
        input1.type = 'hidden';
        input1.name = 'firstname';
        input1.value = '".$row['firstname']."';
        form.appendChild(input1);

        const input2 = document.createElement('input');
        input2.type = 'hidden';
        input2.name = 'lastname';
        input2.value = '".$row['lastname']."';
        form.appendChild(input2);

        // Append the form to the body and submit it
        document.body.appendChild(form);
        form.submit();
    </script>
        
        ";
    }
}catch (Exception $e){
    echo "Error: " . $e->getMessage();
}

?>
