<?php
session_start();
include 'connection.php';

if (\$_SERVER["REQUEST_METHOD"] == "POST") {
    \$name = \$_POST['name'];
    \$password = \$_POST['password'];

    // Fetch user from database
    \$sql = "SELECT * FROM users WHERE name = '\$name'";
    \$result = mysqli_query(\$connection, \$sql);

    if (\$result && mysqli_num_rows(\$result) > 0) {
        \$user = mysqli_fetch_assoc(\$result);
        if (password_verify(\$password, \$user['password'])) {
            \$_SESSION['user_id'] = \$user['id'];
            \$_SESSION['name'] = \$user['name'];
            header("Location: dashboard.php"); 
            exit();
        } else {
            \$error = "Invalid password.";
        }
    } else {
        \$error = "User not found.";
    }
    mysqli_close(\$connection);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login&register_style.css">
    <link rel="stylesheet" href="login_style.css">
</head>
<body>
    <div class="logo">
        <img src="RWDD.png" alt="RWDD Logo">
    </div>
    <div class="container">
        <h2>Login</h2>
        <?php if (!empty(\$error)) { echo "<p style='color:red;'>\$error</p>"; } ?>
        <form id="login-form" action="login.php" method="POST">
            <label for="name">Username:</label>
            <input type="text" id="name" name="name" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="register.php">Register here</a>.</p>
    </div>
</body>
</html>
