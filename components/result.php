<?php
session_start();
include("../classes/Database.php");
$connectDb = new DatabaseConnection("localhost", "root", "", "quiz");
$conn = $connectDb->connect();

$sql = "SELECT * FROM quizques ";
$result = $conn->query($sql);

$arr = array();
if ($result->num_rows >= 0) {
    while ($row = $result->fetch_assoc()) {
        array_push($arr, $row);
    }
}

$trueAns = 0;
$tempArr = array("rightAns" => 0, "wrongAns" => 0, "username" => $_SESSION['username']);
$temp = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $resArr = $_POST['data'];
    $resArr = json_decode($resArr, true);
    $count = 0;
    $wrongAns = 0;
    $totalChecks = 0;
    foreach ($resArr as $item1) {
        foreach ($arr as $item2) {
            if ($item1['sno'] == $item2['sno']) {
                $totalChecks++;
                if ($item1['answer'] == $item2['answer']) {
                    $count++;
                    $tempArr['rightAns']++;

                } else {
                    $tempArr['wrongAns']++;
                }
                break;
            }
        }
    }
    echo json_encode($tempArr);
}
?>