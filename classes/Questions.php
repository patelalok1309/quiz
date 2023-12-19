<?php

class Question
{
    public $question;
    public $opt1;
    public $opt2;
    public $opt3;
    public $opt4;
    public $ans;

    public function __construct($question = null, $opt1 = null, $opt2 = null, $opt3 = null, $opt4 = null, $ans = null)
    {
        $this->question = $question;
        $this->opt1 = $opt1;
        $this->opt2 = $opt2;
        $this->opt3 = $opt3;
        $this->opt4 = $opt4;
        $this->ans = $ans;
    }

    public function insertQuestion($conn)
    {
        $sql = "INSERT INTO `quizques` (`sno`, `question`, `opt1`, `opt2`, `opt3`, `answer`, `opt4`) VALUES (NULL, '$this->question', '$this->opt1', '$this->opt2', '$this->opt3', '$this->ans', '$this->opt4')";

        if ($conn->query($sql) == true) {
            return true;
        } else {
            echo "Sorry try harder";
        }
    }

    public function addOption($conn, $opt, $optval, $id, $setAns = false, $ans = null)
    {
        $sql = "UPDATE `quizques` SET `$opt` = '$optval', `answer`='$ans' WHERE `quizques`.`sno` = '$id'";

        if ($setAns) {
            $sql = "UPDATE `quizques` SET `$opt` = '$optval', `answer`='$ans' WHERE `quizques`.`sno` = '$id'";
        } else {
            $sql = "UPDATE `quizques` SET `$opt` = '$optval' WHERE `quizques`.`sno` = '$id'";
        }
        if ($conn->query($sql) == true) {
            return true;
        } else {
            echo "failed to Add new Option";
        }
    }

    public function checkIfAnsSame($conn, $option, $sno)
    {
        $sql = "SELECT * FROM quizques WHERE $option=answer AND sno='$sno'";
        $result = $conn->query($sql);
        $totalOptions = 0;
        while ($row = $result->fetch_assoc()) {
            for ($i = 1; $i <= 4; $i++) {
                if ($row["opt" . "$i"] !== null) {
                    $totalOptions++;
                }
            }
        }

        if ($totalOptions > 2) {
            $sql = "SELECT * FROM quizques WHERE $option=answer AND sno='$sno'";
            $isSame = $conn->query($sql);
            if (mysqli_num_rows($isSame) == 0) {
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

    public function deleteOption($conn, $opt, $sno)
    {
        if ($this->checkIfAnsSame($conn, "$opt", $sno)) {
            return false;
        } else {
            $optionIndex = substr($opt, -1);
            $nextOption = "opt" . $optionIndex + 1;

            if ($optionIndex != 4) {
                $sql = "UPDATE `quizques` SET  `$opt`=`$nextOption`, `$nextOption` = null  WHERE quizques.sno = '$sno' ";
                if ($conn->query($sql) == true) {
                    return true;
                } else {
                    echo "Sorry try harder";
                }
            } else {
                $sql = "UPDATE `quizques` SET  `$opt` = null  WHERE `quizques`.`sno` = '$sno' ";
                if ($conn->query($sql) == true) {
                    return true;
                } else {
                    echo "Sorry try harder";
                }
            }
        }
    }

    public function markAns($conn, $opt, $sno)
    {
        $sql = "UPDATE `quizques` SET `answer` = `$opt` WHERE `quizques`.`sno` = '$sno'";
        if ($conn->query($sql) == true) {
            return true;
        } else {
            echo "failed to update the answer";
        }
    }

    public function getAll($conn)
    {
        $sql = "SELECT * FROM `quizques`";
        $result = $conn->query($sql);
        echo mysqli_num_rows($result);
        $data = array();
        do {
            array_push($data, $result->fetch_assoc());
        } while ($result->fetch_assoc());

        return json_encode($data);
    }
}


?>