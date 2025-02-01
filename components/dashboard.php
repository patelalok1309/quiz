<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    header("Location: /quiz/index.php", true);
}

include("../classes/Database.php");
include("../classes/Questions.php");
include("../classes/ajax.php");
include("./alert.php");

// object initializations 
$connectDb = new DatabaseConnection('localhost', 'root', '', 'quiz');
// $conn = $connectDb->connect();
$questionObj = new Question();
$ajaxObj = new Ajax();

$quesAlert = false;
$updateAlert = false;
$updateMessage = "";

if (isset($_GET["deleteOpt"])) {
    $optionIndex = $_GET["deleteOpt"];
    $id = $_GET["id"];
    $updateAlert = $questionObj->deleteOption($optionIndex, $id);
    // header('Location: /quiz/components/dashboard.php', true);
    unset($_SESSION["deleteOpt"]);
}
if (isset($_GET["ansOpt"])) {
    $id = $_GET["id"];
    $optionIndex = $_GET["opt"];
    $updateAlert = $questionObj->markAns($optionIndex, $id);
    // header("Location: /quiz/components/dashboard.php", true);
}

// if (isset($_POST['updateOpt'])) {
//     $opt1 = isset($_POST["opt1"]) ? $_POST["opt1"] : null;
//     $opt2 = isset($_POST["opt2"]) ? $_POST["opt2"] : null;
//     $opt3 = isset($_POST["opt3"]) ? $_POST["opt3"] : null;
//     $opt4 = isset($_POST["opt4"]) ? $_POST["opt4"] : null;
//     $ans = isset($_POST["ansFlag"]) ? $_POST["ansFlag"] : null;
//     $id = $_POST["updateOpt"];

//     $optionArray = [$opt1, $opt2, $opt3, $opt4];

//     for ($i = 0; $i <= 3; $i++) {
//         if ($optionArray[$i]) {
//             if (isset($_POST["ansFlag"])) {
//                 $updateAlert = $questionObj->addOption("opt" . $i + 1, $optionArray[$i], $id, true, $ans);
//             } else {
//                 $updateAlert = $questionObj->addOption("opt" . $i + 1, $optionArray[$i], $id);
//             }
//         }
//     }
// }


$result = $questionObj->getAll();
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
    <style>
        .submitBtn {
            width: 150px;
            height: 2rem;
            text-align: center;
            font-size: 1rem;
            border: 1px solid #e50000;
            border-radius: 20px;
            background-color: #e50000;
            color: white;
            box-shadow: none;
        }

        .removeBtn {
            font-size: 0.75rem;
            margin-left: 0.75rem;
            width: auto;
            color: white;
            text-align: center;
            background-color: #d30b0b;
            border: 1px solid black;
            border-radius: 10px;
        }

        .ansFlagBtn {
            font-size: 0.75rem;
            margin-left: 0.75rem;
            width: auto;
            color: white;
            text-align: center;
            background-color: #ff0000;
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
    <div class="container col-md-6 mt-3  border border-1 " style="box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;">
        <h1 class="text-center">Add Question</h1>
        <form class="" action="/quiz/components/dashboard.php" method="POST" id="myform">
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
            <input type="submit" id="submitQue" value="submit" class="submitBtn my-2">
        </form>
    </div>

    <div class="container my-3 ">
        <h2 class="text-center">Question Dashboard</h2>
        <table class="table table-light  table-hover table-bordered " id="myTable">
            <thead class="border border-1 ">
                <tr class="border border-1 ">
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
                <?php if ($result):
                    $srno = 1; ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr scope='row'>
                            <th scope='row'>
                                <?php echo $srno ?>
                            </th>
                            <td>
                                <?php echo $row['question'] ?>
                            </td>
                            <?php $options = array($row['opt1'], $row['opt2'], $row['opt3'], $row['opt4']); ?>

                            <?php for ($i = 0; $i <= 3; $i++): ?>
                                <?php if ($options[$i] == null): ?>
                                    <td>
                                        <form action='/quiz/components/dashboard.php' method='post'>
                                            <?php echo "<input type='hidden' name='updateOpt' id='updateOpt' value=" . $row['sno'] . ">"; ?>
                                            <div class='form-group my-2 d-flex align-items-center justify-content-center'>
                                                <input type='radio' name='ansFlag' class='ansFlag'>
                                                <?php echo "<input type='text' name='opt" . $i + 1 . "' id='opt" . $i + 1 . "' placeholder='Enter Option " . $i + 1 . "' class='form-control form-control-sm w-50 mx-2 h-75 optionInput'>"; ?>
                                                <input type='submit' value='submit' id="updateOpt"
                                                    class='btn btn-outline-secondary btn-sm my-2'>
                                            </div>
                                        </form>
                                    </td>
                                <?php else: ?>
                                    <td>
                                        <?php $option = "opt" . $i + 1; ?>
                                        <div class='d-flex justify-content-start flex-column gap-1 '>
                                            <div>
                                                <?php echo $options[$i] ?>
                                            </div>
                                            <div class='d-flex justify-content-start flex-row gap-1 align-items-start   '>
                                                <?php echo "<button class='removeBtn deleteOpt ' id='opt" . $i + 1 . "' value=" . $row['sno'] . " > remove </button>"; ?>
                                                <?php echo " <button class='ansFlagBtn ansOpt  mx-2' id=" . $row['sno'] . "  value='$option'> answer </button>"; ?>
                                            </div>
                                        </div>
                                    </td>
                                <?php endif ?>
                            <?php endfor ?>
                            </td>
                            <td>
                                <?php echo $row['answer'] ?>
                            </td>
                        </tr>
                        <?php $srno++; ?>
                    <?php endwhile ?>
                <?php endif ?>
                </tr>
            </tbody>
        </table>

        <pre>





        </pre>
    </div>
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
                if (confirm("Are you sure You really wan't to delete note!")) {
                    console.log('yes');
                    window.location = `/quiz/components/dashboard.php?deleteOpt=${optionIndex}&id=${sno}`;
                } else {
                    console.log('no');
                }
            })
        })
        const answersOption = document.getElementsByClassName('ansOpt');
        Array.from(answersOption).forEach((element) => {
            element.addEventListener("click", (e) => {
                sno = e.target.id;
                option = e.target.value;
                console.log(sno, option, e.target);
                if (confirm("Are you sure You really wan't to Mark as answer!")) {
                    console.log('yes');
                    window.location = `/quiz/components/dashboard.php?id=${sno}&opt=${option}&ansOpt=true`;
                } else {
                    console.log('no');
                }
            })
        })

        $(document).ready(function () {
            $('#submitQue').click(function () {
                console.log('hello');
                $.ajax({
                    type: 'POST',
                    url: '/quiz/CRUD/addQuestion.php',
                    success: function (response) {
                        console.log('successfully inseted')
                    },
                    error: function (xhr, status, error) {
                        console.error(error);
                    }
                });
            })


        })
    </script>
</body>

</html>