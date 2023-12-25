<?php
session_start();
include("./mail.php");


include("../classes/Database.php");
$db = new DatabaseConnection('localhost', 'root', "", 'quiz');
$conn = $db->connect();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $dataArr = json_decode($_POST["data"], true);
    $username = $dataArr['username'];
    $dateStamp = date("d/m/y h:i:sa");
    $result = $dataArr['rightAns'];
    $sql = "INSERT INTO `history` (`sno`, `username`, `timestamp`, `result`) VALUES (NULL, '$username', '$dateStamp', '$result')";

    $res = $conn->query($sql);
    if ($res) {
        echo "added successfully" . json_encode(array($username, $dateStamp, $result));
    } else {
        echo "failed to insert data in history";
    }
    sendMail($result);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz - History</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
        crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <script src="//cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
</head>

<body>
    <?php include("./navbar.php"); ?>

    <div class="container mt-4 col-md-8">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover table" id="myTable">
                <thead class="table-dark ">

                    <tr>
                        <th>Sr.no</th>
                        <th>username</th>
                        <th>Timestamp</th>
                        <th>Result</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <?php
                    $username = $_SESSION['username'];
                    $sql = "SELECT * FROM history where `username`='$username'";
                    $result = $conn->query($sql);
                    $index = 1;
                    while ($row = $result->fetch_assoc()) {
                        echo " <tr class='table-primary'>";
                        echo " <td scope='row'> " . $index . "</td>";
                        echo " <td> " . $row['username'] . "</td>";
                        echo " <td> " . $row['timestamp'] . "</td>";
                        echo " <td> " . $row['result'] . "</td>";
                        echo "</tr>";
                        $index++;
                    }
                    ?>
                </tbody>
                <tfoot>
                </tfoot>
            </table>
        </div>
        <caption>
            Quiz History
            <br>
            <?php
            echo "Username :" . $_SESSION['username'];
            ?>
        </caption>
    </div>

    <script>
        let table = new DataTable('#myTable');
    </script>
</body>

</html>