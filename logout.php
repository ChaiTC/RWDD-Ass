<?php
session_start();
session_destroy();
header("Location: login and register.php");
exit();
?>