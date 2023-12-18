<?php
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
echo "Database Array count is " . count($arr);

$trueAns = 0;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $resArr = $_POST['data'];
    $resArr = json_decode($resArr, true);

    echo "\nresponse array size " . count($resArr) . "\n";

    $count = 0;
    $wrongAns = 0;
    $totalChecks = 0;
    foreach ($resArr as $item1) {
        foreach ($arr as $item2) {
            if ($item1['sno'] == $item2['sno']) {
                $totalChecks++;
                if ($item1['answer'] == $item2['answer']) {
                    $count++;
                    echo $item1['sno'] . " " . $item1['answer'];
                    echo "\n";
                } else {
                    $wrongAns++;
                    echo $item1['sno'] . "------------------- " . $item2['answer'];
                    echo "\n";
                }
                break;
            }
        }
    }
    echo "\n ToTal checked questions are :" . $totalChecks;
    echo "The Total true answers are : " . $count;
    echo "\nThe Total false answers are : " . $wrongAns;
}
?>