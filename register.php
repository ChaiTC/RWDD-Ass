<?php
session_start();
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);


    $check_sql = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
    $check_result = mysqli_query($connection, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        
        echo "<script>
            alert('Error: Username or email already exists. Please choose another.');
            window.location.href = 'register.html';
        </script>";
        exit();
    } else {
        
        $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
        if (mysqli_query($connection, $sql)) {
            $_SESSION["username"] = $username; 
            header("Location: login.html"); 
            exit();
        } else {
            // Show error and redirect
            echo "<script>
                alert('Error: Registration failed. Try again.');
                window.location.href = 'register.html';
            </script>";
            exit();
        }
    }
}

mysqli_close($connection);
?>

