<?php
include 'connection.php';

$sql = "SELECT SUM(income_amount) FROM user_income";
$result = mysqli_query($connection, $sql);
$row = mysqli_fetch_array($result);

if ($row) {
    echo $row[0];
} else {
    echo "0";
}

mysqli_close($connection);
?>
