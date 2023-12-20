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
    <style>
        .submitBtn {
            width: 200px;
            height: 2.25rem;
            text-align: center;
            font-size: 1.02rem;
            border: 1px solid #e50000;
            border-radius: 20px;
            background-color: #e50000;
            color: white;
            box-shadow: none;
        }

        .navigationBtn {
            width: 70px;
            height: 2rem;
            text-align: center;
            border: 1px solid #0c6a6b;
            font-size: 1rem;
            border-radius: 1rem;
            background-color: #0c6a6b;
            color: white;
        }
    </style>
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
                    <div id="option1container">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="opt" id="opt1">
                            <label class="form-check-label" for="opt1" id="optLabel1">
                            </label>
                        </div>
                    </div>
                    <div id="option2container">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="opt" id="opt2">
                            <label class="form-check-label" for="opt2" id="optLabel2">
                            </label>
                        </div>
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
                <div class="container d-flex gap-2 my-3 ">
                    <button class="navigationBtn" id="prevBtn">Prev</button>
                    <button class="navigationBtn" id="nextBtn">Next</button>
                </div>

                <div class="container d-flex justify-content-center align-items-center  mt-5">
                    <button class="submitBtn" id="submitBtn">Submit</button>
                </div>
            </div>
        </div>

        <div class="resultField d-flex justify-content-start align-items-center flex-column ">
            <h3 id="playername"></h3>
            <div>True Answers :<span id="trueAns"></span></div>
            <div>False Answers :<span id="wrongAns"></span></div>
            <div><button class="submitBtn mt-4 mb-4 " id="startQuizBtn">Start Quiz</button></div>
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

            $("#startQuizBtn").click(function () {
                location.reload();
                fetchTenQuestion();
            })

            fetchTenQuestion();

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

            function getResponse(data) {
                Data = data;
                for (let i = 0; i < data.length; i++) {
                    options = shuffle([data[i]['opt1'], data[i]['opt2'], data[i]['opt3'], data[i]['opt4']]);
                    Data[i]['opt1'] = options[0];
                    Data[i]['opt2'] = options[1];
                    Data[i]['opt3'] = options[2];
                    Data[i]['opt4'] = options[3];
                }
                $('.resultField > *').css('display', 'none');
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
                })
            })

            function display() {
                $("#srno").text(`${quesIndex + 1}/10`);
                $("#question").text(Data[quesIndex].question);
                optionArray = [Data[quesIndex].opt1, Data[quesIndex].opt2, Data[quesIndex].opt3, Data[quesIndex].opt4];
                for (var i = 0; i <= 3; i++) {
                    if (optionArray[i] != null && optionArray[i] != '') {
                        $(`#option${i + 1}container`).css("display", "block");
                        $(`#optLabel${i + 1}`).text(optionArray[i]).val(optionArray[i]);
                    } else {
                        $(`#option${i + 1}container`).css("display", "none");
                    }
                }
            }

            $('#submitBtn').click(function () {
                if (confirm('Are You sure , you want to submit the quiz ?')) {
                    $('.resultField > *').css('display', 'block');
                    recordAns = JSON.stringify(recordAns);
                    $.ajax({
                        type: 'POST',
                        url: '/cwh/quiz/components/result.php',
                        data: { data: recordAns },
                        success: function (response) {
                            response = JSON.parse(response);
                            $('.quizField').css('display', 'none');
                            $('#playername').text(response.username);
                            $('#trueAns').text(response['rightAns']);
                            $('#wrongAns').text(response['wrongAns']);
                            storeToHistory(response);
                            console.log(response);
                        },
                        error: function (xhr, status, error) {
                            console.error(error);
                        }
                    });
                }
            })
        })


        function storeToHistory(arr) {
            ans = JSON.stringify(arr);
            $.ajax({
                type: 'POST',
                url: '/cwh/quiz/components/history.php',
                data: { data: ans },
                success: function (response) {
                    console.log('added')
                },
                error: function (xhr, status, error) {
                    console.error(error);
                }
            });
        }

        function shuffle(array) {
            let currentIndex = array.length, randomIndex;

            // While there remain elements to shuffle.
            while (currentIndex > 0) {

                // Pick a remaining element.
                randomIndex = Math.floor(Math.random() * currentIndex);
                currentIndex--;

                // And swap it with the current element.
                [array[currentIndex], array[randomIndex]] = [
                    array[randomIndex], array[currentIndex]];
            }

            return array;
        }

    </script>

</body>

</html>