<?php
session_start();
include 'connection.php';

// Ensure database connection is established
if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Fetch total income using prepared statement
$incomeQuery = "SELECT SUM(income_amount) AS total_income FROM user_income";
$incomeStmt = mysqli_prepare($connection, $incomeQuery);
mysqli_stmt_execute($incomeStmt);
$incomeResult = mysqli_stmt_get_result($incomeStmt);
$incomeRow = mysqli_fetch_assoc($incomeResult);
$totalIncome = $incomeRow['total_income'] ?? 0;
mysqli_stmt_close($incomeStmt);

// Fetch expenses grouped by category
$query = "
    SELECT e.category_id, c.category_name, SUM(e.amount) AS total_expense
    FROM user_expenses_table e
    JOIN expenses_categories c ON e.category_id = c.category_id
    GROUP BY e.category_id, c.category_name
";
$result = mysqli_query($connection, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($connection));
}

// Fetch total expenses
$totalExpenseQuery = "SELECT SUM(amount) AS total_expenses FROM user_expenses_table";
$totalExpenseResult = mysqli_query($connection, $totalExpenseQuery);
$totalExpenseRow = mysqli_fetch_assoc($totalExpenseResult);
$totalExpenses = $totalExpenseRow['total_expenses'] ?? 0;

// Calculate balance
$balance = $totalIncome - $totalExpenses;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Summary</title>
    <link rel="stylesheet" href="budgetTool.css">
</head>
<body>
    <?php include 'sidebar.php'; ?>
    <div class="content">
        <main>
            <div class="container">
                <h1>Your Financial Progress</h1>
                <p>View your budgeting and spending trends at a glance.</p>

                <!-- Key Metrics -->
                <div class="summary-box">
                    <h3>Key Metrics</h3>
                    <div class="summary-item">
                        <span>Total Income:</span>
                        <span>RM <?php echo number_format((float)$totalIncome, 2); ?></span>
                    </div>
                    <div class="summary-item">
                        <span>Total Expenses:</span>
                        <span>RM <?php echo number_format((float)$totalExpenses, 2); ?></span>
                    </div>
                    <div class="summary-item balance">
                        <span>Remaining Balance:</span>
                        <span>RM <?php echo number_format((float)$balance, 2); ?></span>
                    </div>
                    <div class="summary-item">
                        <span>Savings Percentage:</span>
                        <span><?php echo ($totalIncome > 0) ? number_format(($balance / $totalIncome) * 100, 2) . "%" : "0%"; ?></span>
                    </div>
                </div>

                <!-- Visualization Section -->
                <div class="visualization">
                    <h3>Expense Breakdown by Category</h3>
                    <table border="1">
                        <tr>
                            <th>Category</th>
                            <th>Total Expense (RM)</th>
                        </tr>
                        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['category_name']); ?></td>
                                <td>RM <?php echo number_format($row['total_expense'], 2); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </table>
                </div>

                <!-- Spending Insights -->
                <div class="tips-box">
                    <h3>Smart Spending Tips</h3>
                    <p id="tips">
                        <?php include 'fetch_tips.php'; ?>
                    </p>
                </div>
            </div>
            <?php include 'footer.php'; ?>
        </main>
        <script src="sidebar.js"></script> 
        <script src="financial_tips.js"></script>
    </div>

</body>
</html>

<?php
// Close database connection
mysqli_close($connection);
?>
