<?php
include 'connection.php';

$user_id = 1; 

$sql = "DELETE FROM user_income WHERE user_id = '$user_id'";
$result = mysqli_query($connection, $sql);

if ($result) {
    echo "success";
} else {
    echo "error";
}

mysqli_close($connection);
?>
