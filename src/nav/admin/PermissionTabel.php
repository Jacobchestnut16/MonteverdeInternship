<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Monteverde Clocks</title>
    <link rel="stylesheet" href="/static/style/viewEvent.css">
    <link rel="stylesheet" href="/static/style/manageTbls.css">
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

$query = "select * from Permissions order by level asc, protocol asc";
$lvl9=[];
$lvl10=[];
$lvl11=[];
$lvl12=[];

$result = $conn->query($query);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        if ($row['level'] == 9){
            $lvl9[] = $row['permission'];
        }elseif ($row['level'] == 10){
            $lvl10[] = $row['permission'];
        }elseif ($row['level'] == 11){
            $lvl11[] = $row['permission'];
        }elseif ($row['level'] == 12) {
            $lvl12[] = $row['permission'];
        }
    }
}


echo "

<form method='post' action='/action/permissionTbl.php'>

<table>
<button type='submit'>Save</button>
<tr>
    <td>Level</td>
    <td>Crew</td>
    <td>Crew-Management</td>
    <td>Management</td>
    <td>Domain-Management</td>
</tr>
<tr>
<td>Reset Passwords</td>
    <td>
    <select name='rp[]' id=''>
    <option value='".$lvl9[0]."'>".($lvl9[0] == 1 ? 'Yes':'No')."</option>
    <option value='0'>No</option>
    <option value='1'>Yes</option>
    </select>
    </td>
    <td>
    <select name='rp[]' id=''>
    <option value='".$lvl10[0]."'>".($lvl10[0] == 1 ? 'Yes':'No')."</option>
    <option value='0'>No</option>
    <option value='1'>Yes</option>
    </select>
    </td>
    <td>
    <select name='rp[]' id=''>
    <option value='".$lvl11[0]."'>".($lvl11[0] == 1 ? 'Yes':'No')."</option>
    <option value='0'>No</option>
    <option value='1'>Yes</option>
    </select>
    </td>
    <td>
    <select name='rp[]' id=''>
    <option value='".$lvl12[0]."'>".($lvl12[0] == 1 ? 'Yes':'No')."</option>
    <option value='0'>No</option>
    <option value='1'>Yes</option>
    </select>
    </td>
</tr>
<tr><td><div class='line'></div></td></tr>
<tr>
<td>Edit Profiles</td>
    <td>
    <select name='rp[]' id=''>
    <option value='".$lvl9[1]."'>".($lvl9[1] == 1 ? 'Yes':'No')."</option>
    <option value='0'>No</option>
    <option value='1'>Yes</option>
    </select>
    </td>
    <td>
    <select name='rp[]' id=''>
    <option value='".$lvl10[1]."'>".($lvl10[1] == 1 ? 'Yes':'No')."</option>
    <option value='0'>No</option>
    <option value='1'>Yes</option>
    </select>
    </td>
    <td>
    <select name='rp[]' id=''>
    <option value='".$lvl11[1]."'>".($lvl11[1] == 1 ? 'Yes':'No')."</option>
    <option value='0'>No</option>
    <option value='1'>Yes</option>
    </select>
    </td>
    <td>
    <select name='rp[]' id=''>
    <option value='".$lvl12[1]."'>".($lvl12[1] == 1 ? 'Yes':'No')."</option>
    <option value='0'>No</option>
    <option value='1'>Yes</option>
    </select>
    </td>
</tr>
<tr><td><div class='line'></div></td></tr>
<tr>
<td>Remove Profiles</td>
    <td>
    <select name='rp[]' id=''>
    <option value='".$lvl9[2]."'>".($lvl9[2] == 1 ? 'Yes':'No')."</option>
    <option value='0'>No</option>
    <option value='1'>Yes</option>
    </select>
    </td>
    <td>
    <select name='rp[]' id=''>
    <option value='".$lvl10[2]."'>".($lvl10[2] == 1 ? 'Yes':'No')."</option>
    <option value='0'>No</option>
    <option value='1'>Yes</option>
    </select>
    </td>
    <td>
    <select name='rp[]' id=''>
    <option value='".$lvl11[2]."'>".($lvl11[2] == 1 ? 'Yes':'No')."</option>
    <option value='0'>No</option>
    <option value='1'>Yes</option>
    </select>
    </td>
    <td>
    <select name='rp[]' id=''>
    <option value='".$lvl12[2]."'>".($lvl12[2] == 1 ? 'Yes':'No')."</option>
    <option value='0'>No</option>
    <option value='1'>Yes</option>
    </select>
    </td>
</tr>
<tr><td><div class='line'></div></td></tr>
<tr>
<td>Add worker</td>
    <td>
    <select name='rp[]' id=''>
    <option value='".$lvl9[3]."'>".($lvl9[3] == 1 ? 'Yes':'No')."</option>
    <option value='0'>No</option>
    <option value='1'>Yes</option>
    </select>
    </td>
    <td>
    <select name='rp[]' id=''>
    <option value='".$lvl10[3]."'>".($lvl10[3] == 1 ? 'Yes':'No')."</option>
    <option value='0'>No</option>
    <option value='1'>Yes</option>
    </select>
    </td>
    <td>
    <select name='rp[]' id=''>
    <option value='".$lvl11[3]."'>".($lvl11[3] == 1 ? 'Yes':'No')."</option>
    <option value='0'>No</option>
    <option value='1'>Yes</option>
    </select>
    </td>
    <td>
    <select name='rp[]' id=''>
    <option value='".$lvl12[3]."'>".($lvl12[3] == 1 ? 'Yes':'No')."</option>
    <option value='0'>No</option>
    <option value='1'>Yes</option>
    </select>
    </td>
</tr>
<tr><td><div class='line'></div></td></tr>
<tr>
<td>Add schedule</td>
    <td>
    <select name='rp[]' id=''>
    <option value='".$lvl9[4]."'>".($lvl9[4] == 1 ? 'Yes':'No')."</option>
    <option value='0'>No</option>
    <option value='1'>Yes</option>
    </select>
    </td>
    <td>
    <select name='rp[]' id=''>
    <option value='".$lvl10[4]."'>".($lvl10[4] == 1 ? 'Yes':'No')."</option>
    <option value='0'>No</option>
    <option value='1'>Yes</option>
    </select>
    </td>
    <td>
    <select name='rp[]' id=''>
    <option value='".$lvl11[4]."'>".($lvl11[4] == 1 ? 'Yes':'No')."</option>
    <option value='0'>No</option>
    <option value='1'>Yes</option>
    </select>
    </td>
    <td>
    <select name='rp[]' id=''>
    <option value='".$lvl12[4]."'>".($lvl12[4] == 1 ? 'Yes':'No')."</option>
    <option value='0'>No</option>
    <option value='1'>Yes</option>
    </select>
    </td>
</tr>
<tr><td><div class='line'></div></td></tr>
<tr>
<td>Add Events</td>
    <td>
    <select name='rp[]' id=''>
    <option value='".$lvl9[5]."'>".($lvl9[5] == 1 ? 'Yes':'No')."</option>
    <option value='0'>No</option>
    <option value='1'>Yes</option>
    </select>
    </td>
    <td>
    <select name='rp[]' id=''>
    <option value='".$lvl10[5]."'>".($lvl10[5] == 1 ? 'Yes':'No')."</option>
    <option value='0'>No</option>
    <option value='1'>Yes</option>
    </select>
    </td>
    <td>
    <select name='rp[]' id=''>
    <option value='".$lvl11[5]."'>".($lvl11[5] == 1 ? 'Yes':'No')."</option>
    <option value='0'>No</option>
    <option value='1'>Yes</option>
    </select>
    </td>
    <td>
    <select name='rp[]' id=''>
    <option value='".$lvl12[5]."'>".($lvl12[5] == 1 ? 'Yes':'No')."</option>
    <option value='0'>No</option>
    <option value='1'>Yes</option>
    </select>
    </td>
</tr>
<tr><td><div class='line'></div></td></tr>
<tr>
<td>Edit Events</td>
    <td>
    <select name='rp[]' id=''>
    <option value='".$lvl9[6]."'>".($lvl9[6] == 1 ? 'Yes':'No')."</option>
    <option value='0'>No</option>
    <option value='1'>Yes</option>
    </select>
    </td>
    <td>
    <select name='rp[]' id=''>
    <option value='".$lvl10[6]."'>".($lvl10[6] == 1 ? 'Yes':'No')."</option>
    <option value='0'>No</option>
    <option value='1'>Yes</option>
    </select>
    </td>
    <td>
    <select name='rp[]' id=''>
    <option value='".$lvl11[6]."'>".($lvl11[6] == 1 ? 'Yes':'No')."</option>
    <option value='0'>No</option>
    <option value='1'>Yes</option>
    </select>
    </td>
    <td>
    <select name='rp[]' id=''>
    <option value='".$lvl12[6]."'>".($lvl12[6] == 1 ? 'Yes':'No')."</option>
    <option value='0'>No</option>
    <option value='1'>Yes</option>
    </select>
    </td>
</tr>
<tr><td><div class='line'></div></td></tr>
<tr>
<td>View Full Time Table</td>
    <td>
    <select name='rp[]' id=''>
    <option value='".$lvl9[7]."'>".($lvl9[7] == 1 ? 'Yes':'No')."</option>
    <option value='0'>No</option>
    <option value='1'>Yes</option>
    </select>
    </td>
    <td>
    <select name='rp[]' id=''>
    <option value='".$lvl10[7]."'>".($lvl10[7] == 1 ? 'Yes':'No')."</option>
    <option value='0'>No</option>
    <option value='1'>Yes</option>
    </select>
    </td>
    <td>
    <select name='rp[]' id=''>
    <option value='".$lvl11[7]."'>".($lvl11[7] == 1 ? 'Yes':'No')."</option>
    <option value='0'>No</option>
    <option value='1'>Yes</option>
    </select>
    </td>
    <td>
    <select name='rp[]' id=''>
    <option value='".$lvl12[7]."'>".($lvl12[7] == 1 ? 'Yes':'No')."</option>
    <option value='0'>No</option>
    <option value='1'>Yes</option>
    </select>
    </td>
</tr>
<tr><td><div class='line'></div></td></tr>
<tr>
<td>Edit Permission Table</td>
    <td>
    <select name='rp[]' id=''>
    <option value='".$lvl9[8]."'>".($lvl9[8] == 1 ? 'Yes':'No')."</option>
    <option value='0'>No</option>
    <option value='1'>Yes</option>
    </select>
    </td>
    <td>
    <select name='rp[]' id=''>
    <option value='".$lvl10[8]."'>".($lvl10[8] == 1 ? 'Yes':'No')."</option>
    <option value='0'>No</option>
    <option value='1'>Yes</option>
    </select>
    </td>
    <td>
    <select name='rp[]' id=''>
    <option value='".$lvl11[8]."'>".($lvl11[8] == 1 ? 'Yes':'No')."</option>
    <option value='0'>No</option>
    <option value='1'>Yes</option>
    </select>
    </td>
    <td>
    <select name='rp[]' id=''>
    <option value='".$lvl12[8]."'>".($lvl12[8] == 1 ? 'Yes':'No')."</option>
    <option value='0'>No</option>
    <option value='1'>Yes</option>
    </select>
    </td>
</tr>
<tr><td><div class='line'></div></td></tr>
</table>

</form>

";