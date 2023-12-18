<?php

$servername = 'localhost';
$username = 'root';
$password = "";
$dbname = "quiz";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Sorry we faild to connect with database" . $conn->connect_error);
}

?>