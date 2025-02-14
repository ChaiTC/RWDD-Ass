<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = 1; // Assume logged-in user
    $income_amount = $_POST['income'];
    $income_frequency = $_POST['income_frequency'];
    $income_date = date('Y-m-d');

    if (!empty($income_amount) && !empty($income_frequency)) {
        // Check if user already has an income record
        $sql_check = "SELECT * FROM user_income WHERE user_id = '$user_id'";
        $result = mysqli_query($connection, $sql_check);

        if (mysqli_num_rows($result) > 0) {
            // Update existing record
            $sql_update = "UPDATE user_income SET income_amount = '$income_amount', 
                           income_frequency = '$income_frequency', income_date = '$income_date' 
                           WHERE user_id = '$user_id'";
            mysqli_query($connection, $sql_update);
        } else {
            // Insert new record
            $sql_insert = "INSERT INTO user_income (user_id, income_amount, income_frequency, income_date) 
                           VALUES ('$user_id', '$income_amount', '$income_frequency', '$income_date')";
            mysqli_query($connection, $sql_insert);
        }

        header("Location: budgetTool.php");
        exit();
    } else {
        echo "Please enter all required fields.";
    }
}

mysqli_close($connection);
?>
