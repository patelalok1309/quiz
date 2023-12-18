<?php
include("../classes/Database.php");
$connectDb = new DatabaseConnection("localhost", "root", "", "quiz");
$conn = $connectDb->connect();

$sql = "SELECT * FROM quizques ORDER BY RAND() LIMIT 10";
$result = $conn->query($sql);

$arr = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        unset($row["answer"]);
        array_push($arr, $row);
    }

    echo json_encode($arr);
}
?>