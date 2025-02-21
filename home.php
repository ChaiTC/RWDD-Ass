<?php
session_start();
include 'connection.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Budget Tool</title>
    <link rel="stylesheet" href="sidebar.css">
    <link rel="stylesheet" href="footer.css">
    <link rel="stylesheet" href="home.css">
</head>
<body>
    <?php include 'sidebar.php'; ?>
  
    <div class="logo">
        <img src="RWDD.png" alt="RWDD Logo">
    </div>

    <div class="main-content">
        <h2>Welcome to the Budget Tool</h2>
        <p>Manage your finances, track expenses, and stay on top of your budget efficiently.</p>

        <div class="home-buttons">
            <a href="quiz_page.php" class="btn">Take a Quiz</a>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script src="sidebar.js"></script>  
    <script src="home.js"></script>
</body>
</html>
