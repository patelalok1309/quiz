<?php
include("../classes/Database.php");
include("../classes/Questions.php");
include("./alert.php");
include("./checkUser.php");

// object initializations 
$connectDb = new DatabaseConnection('localhost', 'root', '', 'quiz');
$questionObj = new Question();
$conn = $connectDb->connect();

$quesAlert = false;
$updateAlert = false;
$updateMessage = "";

if (isset($_GET["deleteOpt"])) {
    $optionIndex = $_GET["deleteOpt"];
    $id = $_GET["id"];
    $updateAlert = $questionObj->deleteOption($conn, $optionIndex, $id);
    header("Location: /cwh/quiz/components/dashboard.php", true);
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $question = isset($_POST["question"]) ? $_POST["question"] : null;
    $opt1 = isset($_POST["opt1"]) ? $_POST["opt1"] : null;
    $opt2 = isset($_POST["opt2"]) ? $_POST["opt2"] : null;
    $opt3 = isset($_POST["opt3"]) ? $_POST["opt3"] : null;
    $opt4 = isset($_POST["opt4"]) ? $_POST["opt4"] : null;
    $ans = isset($_POST["ansFlag"]) ? $_POST["ansFlag"] : null;

    if (isset($_POST['updateOpt'])) {
        $id = $_POST["updateOpt"];
        if ($opt3) {
            if (isset($_POST["ansFlag"])) {
                $updateAlert = $questionObj->addOption($conn, "opt3", $opt3, $id, true, $ans);
            } else {
                $updateAlert = $questionObj->addOption($conn, "opt3", $opt3, $id);
            }
        } else if ($opt4) {
            if (isset($_POST["ansFlag"])) {
                $updateAlert = $questionObj->addOption($conn, "opt4", $opt4, $id, true, $ans);
            } else {
                $updateAlert = $questionObj->addOption($conn, "opt4", $opt4, $id);
            }
        }
    } else {
        $questionObj = new Question($question, $opt1, $opt2, $opt3, $opt4, $ans);
        $questionObj->insertQuestion($conn);
        if ($questionObj) {
            $quesAlert = true;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Quiz App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
        crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <script src="//cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <style>
        .removeBtn {
            font-size: 0.75rem;
            margin-left: 0.75rem;
            width: auto;
            color: white;
            text-align: center;
            background-color: #f04747;
            border: 1px solid black;
            border-radius: 10px;
        }
    </style>
</head>

<body>
    <?php include("./navbar.php"); ?>
    <?php
    if ($quesAlert) {
        echo alert("success", "Question added successfully");
    }
    if ($updateAlert) {
        echo alert("success", "Option updated successfully");
    }

    ?>

    <div class="container col-md-6 mt-3  border border-1 ">
        <h1 class="text-center">Add Question</h1>
        <form class="" action="/cwh/quiz/components/dashboard.php" method="POST" id="myform">
            <div class="form-group my-4 ">
                <label class="form-label col-sm-2" for="question">Question:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="question" name="question"
                        placeholder="Enter Question..." required>
                </div>
            </div>

            <div class="form-group my-2 d-flex">
                <input type="radio" name="ansFlag" class="ansFlag">
                <input type="text" name="opt1" id="opt1" placeholder="Enter Option 1"
                    class="form-control form-control-sm w-50 mx-2 optionInput">
            </div>
            <div class="form-group my-2 d-flex">
                <input type="radio" name="ansFlag" class="ansFlag">
                <input type="text" name="opt2" id="opt2" placeholder="Enter Option 2"
                    class="form-control form-control-sm w-50 mx-2 ">
            </div>
            <input type="submit" value="submit" class="btn btn-outline-secondary btn-sm my-2">
        </form>
    </div>

    <div class="container my-3 ">
        <h2 class="text-center">Question Dashboard</h2>
        <table class="table table-hover table-bordered ">
            <thead>
                <tr>
                    <th>Sr.no</th>
                    <th>Question</th>
                    <th>Option-1</th>
                    <th>Option-2</th>
                    <th>Option-3</th>
                    <th>Option-4</th>
                    <th>Answer</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM `quizques`";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    $srno = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                        <th scope='row'>" . $srno . "</th>
                        <td>" . $row['question'] . "</td>
                        <td>" . $row['opt1'] . " </td>
                        <td>" . $row['opt2'] . "</td>
                        <td>";
                        if ($row["opt3"] == null) {
                            echo "<form action='/cwh/quiz/components/dashboard.php' method='post' >
                                <input type='hidden' name='updateOpt' id='updateOpt' value=" . $row['sno'] . ">
                                <div class='form-group my-2 d-flex align-items-center '>
                                <input type='radio' name='ansFlag' class='ansFlag'>
                                <input type='text' name='opt3' id='opt3' placeholder='Enter Option 3' class='form-control form-control-sm w-50 mx-2 h-75 optionInput'>
                                <input type='submit' value='submit' class='btn btn-outline-secondary btn-sm my-2'>
                                </div>
                                </div>
                                </form>";
                        } else {
                            echo $row['opt3'];
                            echo "<button class='removeBtn deleteOpt float-end ' id='opt3' value=" . $row['sno'] . " > remove </button>";
                        }
                        echo "</td>
                        <td>";
                        if ($row["opt4"] == null) {
                            echo "<form action='/cwh/quiz/components/dashboard.php' method='post' >
                                <input type='hidden' name='updateOpt' id='updateOpt' value=" . $row['sno'] . ">
                                <div class='form-group my-2 d-flex align-items-center '>
                                <input type='radio' name='ansFlag' class='ansFlag'>
                                <input type='text' name='opt4' id='opt4' placeholder='Enter Option 4' class='form-control form-control-sm w-50 mx-2 h-75 optionInput'>
                                <input type='submit' value='submit' class='btn btn-outline-secondary btn-sm my-2'>
                                </div>
                                </div>
                                </form>";
                        } else {
                            echo $row['opt4'];
                            echo "<button class='removeBtn deleteOpt float-end' id='opt4' value=" . $row['sno'] . "> remove </button>";

                        }
                        echo "</td>
                        <td>" . $row['answer'] . "</td>
                        </tr>";
                        $srno++;
                    }
                }
                ?>
            </tbody>
        </table>
    </div>

    <pre>





    </pre>
    <script>

        const answers = document.getElementsByClassName('ansFlag');
        Array.from(answers).forEach((Element) => {
            Element.addEventListener('click', (e) => {
                e.target.value = e.target.nextElementSibling.value;
                console.log(e.target.value);
            })
        })

        const input = document.getElementsByClassName('optionInput');
        Array.from(input).forEach(element => {
            element.addEventListener('change', (e) => {
                element.value = e.target.value;
            })
        });

        const addOptions = document.getElementsByClassName('addOption');
        Array.from(addOptions).forEach(element => {
            element.addEventListener('click', (e) => {
                srno = e.target.id;
            })
        });

        const deletes = document.getElementsByClassName('deleteOpt');
        Array.from(deletes).forEach((element) => {
            element.addEventListener("click", (e) => {
                sno = e.target.value;
                optionIndex = e.target.id;
                if (confirm("Are you sure You really won't to delete note!")) {
                    console.log('yes');
                    window.location = `/cwh/quiz/components/dashboard.php?deleteOpt=${optionIndex}&id=${sno}`;
                } else {
                    console.log('no');
                }
            })
        })
        // const deletes = document.getElementsByClassName('deleteOpt');
        // Array.from(deletes).forEach((element) => {
        //     element.addEventListener("click", (e) => {
        //         sno = e.target.id;
        //         if (confirm("Are you sure You really won't to delete note!")) {
        //             console.log('yes');
        //             window.location = `/cwh/quiz/components/dashboard.php?deleteOpt3=${sno}`;
        //         } else {
        //             console.log('no');
        //         }
        //     })
        // })
        const deletesOpt4 = document.getElementsByClassName('deleteOpt4');
        Array.from(deletesOpt4).forEach((element) => {
            element.addEventListener("click", (e) => {
                sno = e.target.id;
                if (confirm("Are you sure You really won't to delete note!")) {
                    console.log('yes');
                    window.location = `/cwh/quiz/components/dashboard.php?deleteOpt4=${sno}`;
                } else {
                    console.log('no');
                }
            })
        })
    </script>
</body>

</html>