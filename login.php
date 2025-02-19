<?php
session_start();
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['register'])) {
        // Registration Logic
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

        $check_sql = "SELECT * FROM users WHERE name = '$name' OR email = '$email'";
        $check_result = mysqli_query($connection, $check_sql);

        if (mysqli_num_rows($check_result) > 0) {
            $error = "Error: name or email already exists. Please choose another.";
        } else {
            $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";
            if (mysqli_query($connection, $sql)) {
                $_SESSION["name"] = $name;
                header("Location: login.php");
                exit();
            } else {
                $error = "Error: Registration failed. Try again.";
            }
        }
    } elseif (isset($_POST['login'])) {
        // Login Logic
        $name = $_POST['name'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM users WHERE name = '$name'";
        $result = mysqli_query($connection, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['name'] = $user['name'];
                header("Location: dashboard.php");
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
    <link rel="stylesheet" href="login&register_style.css">
</head>
<body>
    <div class="logo">
        <img src="RWDD.png" alt="RWDD Logo">
    </div>
    <div class="container">
        <h2>Login</h2>
        <?php if (!empty($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
        <form id="login-form" action="" method="POST">
            <label for="name">name:</label>
            <input type="text" id="name" name="name" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit" name="login">Login</button>
        </form>
        <p>Don't have an account? <a href="#" onclick="showRegister()">Register here</a>.</p>
    </div>
    
    <div class="container" id="register-container" style="display:none;">
        <h2>Register</h2>
        <form id="register-form" action="" method="POST">
            <label for="name">name:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

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