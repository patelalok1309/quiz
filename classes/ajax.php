<?php

// include("Questions.php");
// include("Database.php");

class Ajax extends Question
{

    public function __construct()
    {
        parent::__construct();
    }

    public function addQuestion()
    {
        if (isset($_POST['question'])) {
            $question = isset($_POST["question"]) ? $_POST["question"] : null;
            $opt1 = isset($_POST["opt1"]) ? $_POST["opt1"] : null;
            $opt2 = isset($_POST["opt2"]) ? $_POST["opt2"] : null;
            $opt3 = isset($_POST["opt3"]) ? $_POST["opt3"] : null;
            $opt4 = isset($_POST["opt4"]) ? $_POST["opt4"] : null;
            $ans = isset($_POST["ansFlag"]) ? $_POST["ansFlag"] : null;

            $questionObj = new Question($question, $opt1, $opt2, $opt3, $opt4, $ans);
            $questionObj->insertQuestion();
            if ($questionObj) {
                $quesAlert = true;
            }
        }
    }

}



?>