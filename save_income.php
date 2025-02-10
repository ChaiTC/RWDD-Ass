<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = 1; // Assume a logged-in user
    $income_amount = $_POST['income'];
    $income_frequency = $_POST['income_frequency'];
    $income_date = date('Y-m-d');

    if (!empty($income_amount) && !empty($income_frequency)) {
        $sql = "INSERT INTO user_income (user_id, income_amount, income_frequency, income_date) 
                VALUES ('$user_id', '$income_amount', '$income_frequency', '$income_date')";

        if (mysqli_query($connection, $sql)) {
            header("Location: budgetTool.php"); // Redirect back to the main page
            exit();
        } else {
            echo "Error: " . mysqli_error($connection);
        }
    } else {
        echo "Please enter all required fields.";
    }
}

mysqli_close($connection);
?>
