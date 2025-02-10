<?php
include 'connection.php';

$user_id = 1; // Change this for logged-in user

// Get total spending for each category
$sql = "SELECT category_id, SUM(amount) as total FROM user_expenses_table 
        WHERE user_id = '$user_id' GROUP BY category_id ORDER BY total DESC LIMIT 1";
$result = mysqli_query($connection, $sql);
$row = mysqli_fetch_array($result);

// Default message (if no high spending is found)
$tip = "Your spending looks balanced. Keep tracking your expenses!";

if ($row) {
    $category_id = $row['category_id'];
    $highest_spending = $row['total'];

    // Get total income
    $incomeQuery = "SELECT SUM(income_amount) FROM user_income WHERE user_id = '$user_id'";
    $incomeResult = mysqli_query($connection, $incomeQuery);
    $incomeRow = mysqli_fetch_array($incomeResult);
    $totalIncome = $incomeRow[0] ? $incomeRow[0] : 0;

    // Calculate percentage of income spent
    $spendingPercentage = ($totalIncome > 0) ? ($highest_spending / $totalIncome) * 100 : 0;

    // Only give a tip if spending is high
    if ($spendingPercentage > 30) { // Only warn if spending >30% of income
        if ($category_id == 1) {
            $tip = "You're spending a lot on **Food** (RM $highest_spending). Try cooking at home to save money.";
        } elseif ($category_id == 2) {
            $tip = "Your **Transport** costs (RM $highest_spending) are high. Consider using public transport or carpooling.";
        } elseif ($category_id == 3) {
            $tip = "Entertainment spending (RM $highest_spending) is high! Look for free activities or limit subscriptions.";
        }

        // Extra warning if expenses are >50% of income
        if ($spendingPercentage > 50) {
            $tip .= " Also, your expenses in this category are **over 50%** of your income. Try saving more!";
        }
    }
}

echo $tip;
?>
