<?php
include 'connection.php';

// Fetch Total Income
$incomeQuery = "SELECT SUM(income_amount) FROM user_income";
$incomeResult = mysqli_query($connection, $incomeQuery);
$incomeRow = mysqli_fetch_array($incomeResult);
$totalIncome = $incomeRow[0] ? $incomeRow[0] : 0;

// Fetch Total Expenses
$expenseQuery = "SELECT SUM(amount) FROM user_expenses_table";
$expenseResult = mysqli_query($connection, $expenseQuery);
$expenseRow = mysqli_fetch_array($expenseResult);
$totalExpenses = $expenseRow[0] ? $expenseRow[0] : 0;

// Calculate Balance
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

    <!-- Main Content Wrapper -->
    <div class="content">
        <header>
            <div class="logo">
                <img src="RWDD.png" alt="App Logo">
                <h1>Budget Tool</h1>
            </div>
        </header>

        <main>
            <h1>Your Monthly Budget</h1>
            <p>Track your income and expenses to better manage your finances.</p>

            <!-- Income Input -->
            <form action="save_income.php" method="POST">
                <h2>Enter Income</h2>
                <label for="income">Amount:</label>
                <input type="number" id="income" name="income" required>

                <label for="income_frequency">Income Frequency:</label>
                <select id="income_frequency" name="income_frequency" required>
                    <option value="Monthly">Monthly</option>
                    <option value="Weekly">Weekly</option>
                </select>

                <button type="submit">Save Income</button>
            </form>

            <form action="save_expenses.php" method="POST">
                <h2>Add Expense</h2>
                <label for="category">Category:</label>
                <select id="category" name="category_id">
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

            <!-- Summary Section -->
            <div>
                <h2>Summary</h2>
                <p>Total Income: RM <?php echo $totalIncome; ?></p>
                <p>Total Expenses: RM <?php echo $totalExpenses; ?></p>
                <p>Balance: RM <?php echo $balance; ?></p>
            </div>

            <div>
                <h2>Spending Tips</h2>
                <p id="tips">
                    <?php include 'fetch_tips.php';?>
                </p>
            </div>
        </main>

        <footer>
            <p> 2025 Budget Tool </p>
        </footer>
    </div>

    <script src='budgetTool.js'></script>
</body>
</html>
