<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = 1; // Assume logged-in user
    $category_id = isset($_POST['category_id']) ? mysqli_real_escape_string($connection, $_POST['category_id']) : '';
    $amount = isset($_POST['amount']) ? floatval($_POST['amount']) : 0;
    $description = isset($_POST['description']) ? mysqli_real_escape_string($connection, $_POST['description']) : '';
    $date = date('Y-m-d');

    // Prevent inserting empty values
    if (!empty($category_id) && $amount > 0) {
        $sql = "INSERT INTO user_expenses_table (user_id, category_id, amount, date, description) 
                VALUES ('$user_id', '$category_id', '$amount', '$date', '$description')";

        mysqli_query($connection, $sql);
    }

    mysqli_close($connection);
    header("Location: budgetTool.php"); // Redirect with no errors
    exit();
}
?>
