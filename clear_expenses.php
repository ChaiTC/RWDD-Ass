<?php
include 'connection.php';

$user_id = 1; // Adjust this based on your session/user authentication

$sql = "DELETE FROM user_expenses_table WHERE user_id = '$user_id'";
$result = mysqli_query($connection, $sql);

if ($result) {
    echo "success";
} else {
    echo "error: " . mysqli_error($connection); // Show MySQL error
}

mysqli_close($connection);
?>
