<?php
include 'connection.php';

$user_id = 1;
$sql = "SELECT SUM(income_amount) AS total_income FROM user_income WHERE user_id = $user_id";
$result = mysqli_query($connection, $sql);
$row = mysqli_fetch_assoc($result);

echo number_format($row['total_income'], 2, '.', '');

mysqli_close($connection);
?>
