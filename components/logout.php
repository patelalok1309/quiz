<?php
session_start();
include("./alert.php");

alert("success", "Logged out successfully");
header("Location: /quiz/components/login.php", true);

session_destroy();
?>