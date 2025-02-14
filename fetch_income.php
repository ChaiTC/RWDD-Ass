<?php
include 'connection.php';

$userID = 1;
$sql = "SELECT income_amount, income_frequency FROM user_income WHERE user_id = $userID";
$result = mysqli_query($connection, $sql);

$totalIncome = 0;

while ($row = mysqli_fetch_assoc($result)) {
    $income = floatval($row['income_amount']);
    $frequency = trim($row['income_frequency']); 

    if ($frequency == "weekly") { 
        $income *= 4;
    }

    $totalIncome += $income;
}

echo number_format($totalIncome, 2, '.', '');

mysqli_close($connection);
?>
