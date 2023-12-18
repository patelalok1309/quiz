<?php

class Quiz
{
    public $quizTimestamp;
    public $username;

    public function __construct($quizTimestamp, $username)
    {
        $this->quizTimestamp = date('d/m/Y h:i:s a', time());
        $this->username = $username;
    }

    public function getQuestions()
    {

    }
}

?>