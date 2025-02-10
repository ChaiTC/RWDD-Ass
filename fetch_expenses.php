<?php
include 'connection.php';

$sql = "SELECT SUM(amount) FROM user_expenses_table";
$result = mysqli_query($connection, $sql);
$row = mysqli_fetch_array($result);

if ($row) {
    echo $row[0];
} else {
    echo "0";
}

mysqli_close($connection);
?>
