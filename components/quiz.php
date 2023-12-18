<?php
include("./classes/Quiz.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
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
    <div class="container">
        <div class="quizField">
            <div class="container my-3 ">
                <div class="questionField">
                    Question:<span id="srno"></span>
                    <h3 id="question"></h3>
                </div>
                <div class="optionField my-2 ps-1">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="opt" id="opt1">
                        <label class="form-check-label" for="opt1" id="optLabel1">
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="opt" id="opt2">
                        <label class="form-check-label" for="opt2" id="optLabel2">
                        </label>
                    </div>
                    <div id="option3container">
                        <div class="form-check ">
                            <input class="form-check-input" type="radio" name="opt" id="opt3">
                            <label class="form-check-label" for="opt3" id="optLabel3">
                            </label>
                        </div>
                    </div>
                    <div id="option4container">
                        <div class="form-check option4">
                            <input class="form-check-input" type="radio" name="opt" id="opt4">
                            <label class="form-check-label" for="opt4" id="optLabel4">
                            </label>
                        </div>
                    </div>
                </div>
                <div class="container d-flex justify-content-between my-3 ">
                    <button class="btn btn-secondary " id="prevBtn">
                        Prev </button>
                    <button class="btn btn-secondary " id="nextBtn">Next</button>
                </div>

                <div class="container d-flex justify-content-end my-3">
                    <button class="btn btn-outline-primary " id="submitBtn">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            let Data;
            let quesIndex = 0;
            let recordAns = [];
            for (let i = 0; i < 10; i++) {
                recordAns.push({ "answer": "", "sno": null, "option": null });
            }

            async function fetchTenQuestion() {
                await $.ajax({
                    type: 'get',
                    dataType: "json",
                    url: "/cwh/quiz/components/getQuestions.php",
                    success: function (response) {
                        getResponse(response);
                    }
                })
            }
            fetchTenQuestion();

            function getResponse(data) {
                Data = data;
                display();
            }

            function removeSelection() {
                $('[name="opt"]').prop("checked", false)
            }

            $("#prevBtn").click(function () {
                if (quesIndex >= 1) {
                    quesIndex--;
                    removeSelection();
                }

                if (recordAns[quesIndex].option) {
                    $selectedOpt = recordAns[quesIndex].option;
                    $($selectedOpt).prop("checked", true);
                }
                display();
            });

            $("#nextBtn").click(function () {
                if (quesIndex < 9) {
                    quesIndex++;
                    removeSelection();
                }
                if (recordAns[quesIndex].option) {
                    $selectedOpt = recordAns[quesIndex].option;
                    $($selectedOpt).prop("checked", true);
                }
                display();
            });

            const answers = $('[name="opt"]');
            Array.from(answers).forEach((Element) => {
                Element.addEventListener('click', (e) => {
                    e.target.value = e.target.nextElementSibling.value;
                    recordAns[quesIndex].answer = e.target.value;
                    recordAns[quesIndex].sno = Data[quesIndex].sno;
                    recordAns[quesIndex].option = e.target;
                    console.clear();
                })
            })

            function display() {
                $("#srno").text(`${quesIndex + 1}/10`);
                $("#question").text(Data[quesIndex].question);
                $("#optLabel1").text(Data[quesIndex].opt1).val(Data[quesIndex].opt1);
                $("#optLabel2").text(Data[quesIndex].opt2).val(Data[quesIndex].opt2);

                if (Data[quesIndex].opt3 != null && Data[quesIndex].opt3 != '') {
                    $("#option3container").css("display", "block");
                    $("#optLabel3").text(Data[quesIndex].opt3).val(Data[quesIndex].opt3);
                } else {
                    $("#option3container").css("display", "none");
                }
                if (Data[quesIndex].opt4 != null && Data[quesIndex].opt4 != '') {
                    $("#option4container").css("display", "block");
                    $("#optLabel4").text(Data[quesIndex].opt4).val(Data[quesIndex].opt4);
                } else {
                    $("#option4container").css("display", "none");
                }
            }

            $('#submitBtn').click(function () {
                if (confirm('Are You sure , you want to submit the quiz ?')) {
                    recordAns = JSON.stringify(recordAns);
                    $.ajax({
                        type: 'POST',
                        url: '/cwh/quiz/components/result.php',
                        data: { data: recordAns },
                        success: function (response) {
                            console.log(response);
                        },
                        error: function (xhr, status, error) {
                            console.error(error);
                        }
                    });
                }
            })
        })

        function shuffleArray(array) {
            for (let i = array.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                [array[i], array[j]] = [array[j], array[i]];
            }
            return array;
        }

    </script>

</body>

</html>