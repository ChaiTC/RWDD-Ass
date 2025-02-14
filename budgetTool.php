<?php
session_start();
include 'connection.php';
include 'header.php';
include 'sidebar.php';

// Ensure database connection is established
if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Fetch total income
$incomeQuery = "SELECT SUM(income_amount) AS total_income FROM user_income";
$incomeResult = mysqli_query($connection, $incomeQuery);
$incomeRow = mysqli_fetch_assoc($incomeResult);
$totalIncome = $incomeRow['total_income'] ?? 0;

// Fetch total expenses
$expenseQuery = "SELECT SUM(amount) AS total_expenses FROM user_expenses_table";
$expenseResult = mysqli_query($connection, $expenseQuery);
$expenseRow = mysqli_fetch_assoc($expenseResult);
$totalExpenses = $expenseRow['total_expenses'] ?? 0;

// Calculate balance
$balance = $totalIncome - $totalExpenses;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Budget Tool</title>
    <link rel="stylesheet" href="budgetTool.css">
</head>
<body>

    <div class="sidebar">
        <div class="logo-container">
            <img src="RWDD.png" alt="App Logo">
            <h1>Budget Tool</h1>
        </div>
        <ul>
            <li><img src="home-icon.png" alt="Home"> <h1>HOME</h1></li>
            <li><img src="quiz-icon.png" alt="Quiz"> <h1>QUIZ</h1></li>
            <li><img src="budget-icon.png" alt="Budget Tool"> <h1>BUDGET TOOL</h1></li>
            <li><img src="progress-icon.png" alt="Progress"> <h1>PROGRESS</h1></li>
            <li><img src="tips-icon.png" alt="Tips"> <h1>TIPS</h1></li>
        </ul>
    </div>

    <div class="content">
        <main>
            <div class="container">
                <h1>Your Monthly Budget</h1>
                <p>Track your income and expenses to better manage your finances.</p>

                <!-- Income Form -->
                <div class="form-container">
                    <h2>Enter Income</h2>
                    <form action="save_income.php" method="POST">
                        <label for="income">Amount:</label>
                        <input type="number" id="income" name="income" required>

                        <label for="income_frequency">Income Frequency:</label>
                        <select id="income_frequency" name="income_frequency" required>
                            <option value="Monthly">Monthly</option>
                            <option value="Weekly">Weekly</option>
                        </select>

                        <button type="submit">Save Income</button>
                    </form>
                </div>

                <!-- Expense Form -->
                <div class="form-container">
                    <h2>Add Expense</h2>
                    <form action="save_expenses.php" method="POST">
                        <label for="category">Category:</label>
                        <select id="category" name="category_id" required>
                            <option value="1">Food</option>
                            <option value="2">Transport</option>
                            <option value="3">Entertainment</option>
                        </select>

                        <label for="amount">Amount:</label>
                        <input type="number" id="amount" name="amount" required>

                        <label for="description">Description:</label>
                        <input type="text" id="description" name="description" required>

                        <button type="submit">Add Expense</button>
                    </form>
                </div>

                <!-- Budget Summary & Spending Tips -->
                <div class="summary-tips-container">
                    <!-- Budget Summary Box -->
                    <div class="summary-box">
                        <h3>Your Progress <span>(monthly)</span></h3>
                        <div class="summary-item">
                            <span>Total Income</span>
                            <span>RM <?php echo number_format($totalIncome, 2); ?></span>
                        </div>
                        <div class="summary-item">
                            <span>Total Expenses</span>
                            <span>RM <?php echo number_format($totalExpenses, 2); ?></span>
                        </div>
                        <div class="summary-item balance">
                            <span>Balance</span>
                            <span>RM <?php echo number_format($balance, 2); ?></span>
                        </div>
                    </div>

                    <!-- Spending Tips Box -->
                    <div class="tips-box">
                        <h3>Smart Spending Tips</h3>
                        <p id="tips">
                            <?php include 'fetch_tips.php'; ?>
                        </p>
                    </div>
                </div>
            </div>
        </main>

        <!-- Mobile Menu Button -->
        <button class="menu-btn" onclick="toggleSidebar()">☰ Menu</button>

        <?php include 'footer.php'; ?>
    </div>

</body>
</html>
