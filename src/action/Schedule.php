<?php
$servername = "database"; //will change after new env setup
$username = "user";
$password = "pass";
$dbname = "mcshedual";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo "Connection failed: " . $conn->connect_error;
}


$id = $_POST['auth'];
$event = $_POST['event'];
$works = $_POST['works'];
$month = $_POST['month'];


for ($i = 0; $i < count($id); $i++) {
    $needsUpdating[$i] = 1;
}
for ($i = 0; $i < count($works); $i++) {
    echo "<p>Searching ........................ ".$i."/".count($works)."</p>";
    if ($works[$i] == 'on') {
        $query = "SELECT EventUsers.id as 'id' FROM EventUsers join Events on EventUsers.eventID = Events.id WHERE eventID = '$event[$i]' AND userID = '$id[$i]' and month(date) = '" . $month . "'";
        if ($result = $conn->query($query)) {
            if ($result->num_rows > 0) {
                echo "<p>Found .................. ".$i."/".count($works)." No Update</p>";
            }else{
                $query = "INSERT INTO EventUsers (eventID, userID) VALUES ('$event[$i]', '$id[$i]')";
                if ($conn->query($query) === TRUE) {
                    echo "<p>Added ".$i."/".count($works)." .................. Sucessful</p>";
                    $query = "Select workersAdded From Events WHERE id = '$event[$i]'";
                    if ($result = $conn->query($query)) {
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $workersAdded = $row["workersAdded"]+1;
                                $query = "UPDATE Events SET workersAdded=$workersAdded WHERE id = '$event[$i]'";
                                if ($conn->query($query) === TRUE) {}else{
                                    echo "<p>Error indexing ................... ".$i."/".count($works)."</p>";
                                }
                            }
                        }
                    }else{
                        echo "<p>Error indexing ................... ".$i."/".count($works)."</p>";
                    }
                }else{
                    echo "<p>Error Adding ................... ".$i."/".count($works)."</p>";
                }
            }
        }else{
            echo "<p>Searching Error on ............... ".$i."/".count($works)."</p>";
        }
    }else{
        $query = "SELECT EventUsers.id as 'id' FROM EventUsers join Events on EventUsers.eventID = Events.id WHERE eventID = '$event[$i]'
                                      AND userID = '$id[$i]' and month(date) = '" . $month . "'";
        if ($result = $conn->query($query)) {
            if ($result->num_rows > 0) {
                $query = "DELETE FROM EventUsers WHERE eventID = '$event[$i]' AND userID = '$id[$i]'";
                if ($conn->query($query) === TRUE) {
                    echo "<p>Rmoved ".$i."/".count($works)." ................ Sucessful</p>";
                    $query = "Select workersAdded From Events WHERE id = '$event[$i]'";
                    if ($result = $conn->query($query)) {
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $workersAdded = $row["workersAdded"]-1;
                                $query = "UPDATE Events SET workersAdded=$workersAdded WHERE id = '$event[$i]'";
                                if ($conn->query($query) === TRUE) {}else{
                                    echo "<p>Error indexing ................... ".$i."/".count($works)."</p>";
                                }
                            }
                        }
                    }else{
                        echo "<p>Error indexing ................... ".$i."/".count($works)."</p>";
                    }

                }else{
                    echo "<p>Error Deleting ................... ".$i."/".count($works)."</p>";
                }
            }else{
                echo "<p>Found .................. ".$i."/".count($works)." No Update</p>";
            }
        }else{
            echo "<p>Searching Error on ............... ".$i."/".count($works)."</p>";
        }
    }
}