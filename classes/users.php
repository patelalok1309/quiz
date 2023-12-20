<?php

class Users
{
    public $username;
    public $password;
    public $email;

    public function __construct($username = null, $password = null, $email = null)
    {
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
    }

    public function insertNewUser($conn, $username, $password, $email)
    {
        $sql = "INSERT INTO `users` ( `username`, `email`, `password`) VALUES ( '$username', '$email', '$password')";
        if ($conn->query($sql) == true) {
            return true;
        } else {
            echo "failed to insert data";
        }
    }
}

?>