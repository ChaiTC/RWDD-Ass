<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['income'])) {
    $user_id = 1; // Assume logged-in user
    $income_amount = floatval($_POST['income']);
    $income_date = date('Y-m-d');

    // Insert new record
    $sql_insert = "INSERT INTO user_income (user_id, income_amount, income_date) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($connection, $sql_insert);
    mysqli_stmt_bind_param($stmt, "ids", $user_id, $income_amount, $income_date);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($connection);

    header("Location: budgetTool.php");
    exit();
}
?>
