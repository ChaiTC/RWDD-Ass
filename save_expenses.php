<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = 1; // Change this to the logged-in user ID
    $category_id = $_POST['category_id'];
    $amount = $_POST['amount'];
    $description = $_POST['description'];
    $date = date('Y-m-d');

    // Insert new expense
    $sql = "INSERT INTO user_expenses_table (user_id, category_id, amount, date, description) 
            VALUES ('$user_id', '$category_id', '$amount', '$date', '$description')";

    if (mysqli_query($connection, $sql)) {
        header("Location: budgetTool.php"); // Redirect back to the main page
        exit();
    } else {
        echo "Error: " . mysqli_error($connection);
    }
}

mysqli_close($connection);
?>
