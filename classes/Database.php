<?php

class DatabaseConnection
{
    protected $servername;
    protected $username;
    protected $password;
    protected $database;
    public $conn;


    public function __construct($servername, $username, $password, $database)
    {
        $this->servername = $servername;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
    }

    public function connect()
    {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->database);
        if ($this->conn->connect_error) {
            die("Sorry We failed to connect with database " . $this->conn->connect_error);
        } else {
            return $this->conn;
        }
    }
}

?>