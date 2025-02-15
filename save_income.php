<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $income = isset($_POST["income"]) ? trim($_POST["income"]) : "";

    error_log("Received income: " . $income); // Logs received income
    error_log("Type of income: " . gettype($income));

    if (!is_numeric($income) || floatval($income) <= 0) {
        echo "Invalid income: $income"; // Debugging output
    } else {
        echo "success"; // Return success if valid
    }
}
?>