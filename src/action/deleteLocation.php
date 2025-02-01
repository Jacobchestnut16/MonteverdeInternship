<?php
$servername = "database"; //will change after new env setup
$username = "user";
$password = "pass";
$dbname = "mcshedual";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo "Connection failed: " . $conn->connect_error;
}


if (isset($_GET["eventID"])){
    $query = "SELECT * FROM EventLocation WHERE ID = '".$_GET["eventID"]."'";
    $result = $conn->query($query);
    echo "
    <form action='deleteEvent.php' method='POST'>
    <label for='eventID'>Would you like to delete ".$result['eventType']."</label>
    <input type='hidden' name='eventID' value='".$_GET["eventID"]."'> >
    <button type='submit'>Confirm</button>
    </form>
    
    ";
}

if (isset($_POST['eventID'])){

    $query = "DELETE FROM EventLocation WHERE id = '".$_POST['eventID']."'";
    if ($conn->query($query) === TRUE) {
        echo "Removed successfully";
        include "../nav/admin/Location.php";
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
        include "../nav/admin/Location.php";
    }

}