<?php
session_start();
include 'connection.php';

$error = ""; // Initialize error variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['register']) && isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password'])) {
        // Registration Logic
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $password = password_hash(trim($_POST['password']), PASSWORD_BCRYPT);

        $check_sql = "SELECT * FROM users WHERE name = ? OR email = ?";
        $stmt = mysqli_prepare($connection, $check_sql);
        mysqli_stmt_bind_param($stmt, "ss", $name, $email);
        mysqli_stmt_execute($stmt);
        $check_result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($check_result) > 0) {
            $error = "Error: name or email already exists. Please choose another.";
        } else {
            $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($connection, $sql);
            mysqli_stmt_bind_param($stmt, "sss", $name, $email, $password);
            
            if (mysqli_stmt_execute($stmt)) {
                $_SESSION["name"] = $name;
                header("Location: login.php");
                exit();
            } else {
                $error = "Error: Registration failed. Try again.";
            }
        }
    } elseif (isset($_POST['login']) && isset($_POST['name']) && isset($_POST['password'])) {
        // Login Logic
        $name = trim($_POST['name']);
        $password = trim($_POST['password']);

        $sql = "SELECT * FROM users WHERE name = ?";
        $stmt = mysqli_prepare($connection, $sql);
        mysqli_stmt_bind_param($stmt, "s", $name);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['name'] = $user['name'];
                header("Location: dashboard.html");
                exit();
            } else {
                $error = "Invalid password.";
            }
        } else {
            $error = "User not found.";
        }
    }
    mysqli_close($connection);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Register</title>
    <link rel="stylesheet" href="login_style.css">
</head>
<body>
    <div class="logo">
        <img src="RWDD.png" alt="RWDD Logo">
    </div>
    <div class="container">
        <h2>Login</h2>
        <?php if (!empty($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
        <form id="login-form" action="" method="POST">
            <label for="login-name">Name:</label>
            <input type="text" id="login-name" name="name" required>

            <label for="login-password">Password:</label>
            <input type="password" id="login-password" name="password" required>

            <button type="submit" name="login">Login</button>
        </form>
        <p>Don't have an account? <a href="#" onclick="showRegister()">Register here</a>.</p>
    </div>
    
    <div class="container" id="register-container" style="display:none;">
        <h2>Register</h2>
        <form id="register-form" action="" method="POST">
            <label for="register-name">Name:</label>
            <input type="text" id="register-name" name="name" required>

            <label for="register-email">Email:</label>
            <input type="email" id="register-email" name="email" required>

            <label for="register-password">Password:</label>
            <input type="password" id="register-password" name="password" required>

            <button type="submit" name="register">Register</button>
        </form>
        <p>Already have an account? <a href="#" onclick="showLogin()">Login here</a>.</p>
    </div>

    <script>
        function showRegister() {
            document.getElementById('register-container').style.display = 'block';
            document.getElementById('login-form').parentElement.style.display = 'none';
        }
        function showLogin() {
            document.getElementById('register-container').style.display = 'none';
            document.getElementById('login-form').parentElement.style.display = 'block';
        }
    </script>
</body>
</html>
