<?php
class Question extends DatabaseConnection
{
    public $question;
    public $opt1;
    public $opt2;
    public $opt3;
    public $opt4;
    public $ans;

    public function __construct($question = null, $opt1 = null, $opt2 = null, $opt3 = null, $opt4 = null, $ans = null)
    {
        parent::__construct('localhost', 'root', '', 'quiz');
        $this->question = $question;
        $this->opt1 = $opt1;
        $this->opt2 = $opt2;
        $this->opt3 = $opt3;
        $this->opt4 = $opt4;
        $this->ans = $ans;
    }


    public function insertQuestion()
    {
        $data = array("question" => $this->question, "answer" => $this->ans, "opt1" => $this->opt1, "opt2" => $this->opt2, "opt3" => $this->opt3, "opt4" => $this->opt4);

        return $this->insert("quizques", $data);
    }


    public function addOption($opt, $optval, $id, $setAns = false, $ans = null)
    {
        if ($setAns) {
            $data = "`$opt` = '$optval' , `answer`= '$ans' ";
        } else {
            $data = "`$opt` = '$optval'";
        }
        $condition = "`quizques`.`sno` = $id";
        return $this->update("quizques", $data, $condition);
    }

    public function checkIfAnsSame($option, $sno): bool
    {

        $condition = "sno='$sno'";
        $result = $this->select('quizques', '*', $condition);
        $totalOptions = 0;

        if ($result) {

            while ($row = $result->fetch_assoc()) {

                for ($i = 1; $i <= 4; $i++) {
                    if ($row["opt" . "$i"] != null) {
                        $totalOptions++;
                    }
                }
            }

            if ($totalOptions > 2) {
                $condition = "$option=answer AND sno='$sno'";
                $result = $this->select("quizques", "*", $condition);
                return true;

            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function deleteOption($opt, $sno)
    {
        if (!$this->checkIfAnsSame("$opt", $sno)) {
            return false;
        } else {
            $optionIndex = substr($opt, -1);
            $nextOption = "opt" . $optionIndex + 1;

            if ($optionIndex != 4) {
                $data = "`$opt`=`$nextOption`, `$nextOption` = null";
                $condition = "quizques.sno = '$sno'";
                return $this->update("quizques", $data, $condition);
            } else {
                $data = "`$opt`= null";
                $condition = "quizques.sno = '$sno'";
                return $this->update("quizques", $data, $condition);
            }
        }
    }

    public function markAns($opt, $sno)
    {
        $data = "`answer`=`$opt`";
        $condition = "quizques.sno = '$sno'";
        return $this->update("quizques", $data, $condition);
    }

    public function getAll()
    {
        $result = $this->select("quizques");
        return $result;
    }

}


?>