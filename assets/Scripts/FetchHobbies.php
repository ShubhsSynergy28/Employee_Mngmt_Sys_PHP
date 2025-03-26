<?php 
$hobbyQuery = "SELECT Hid, Hname FROM hobbies";
$hobbyResult = $conn->query($hobbyQuery);

if ($hobbyResult->num_rows > 0) {
    while($row = $hobbyResult->fetch_assoc()) {
        echo '<option value="'.$row['Hid'].'">'.$row['Hname'].'</option>';
    }
} else {
    echo '<option value="0">No hobbies found</option>';
}
?>