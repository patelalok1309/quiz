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
        $this->conn = mysqli_connect($this->servername, $this->username, $this->password, $this->database);

        if ($this->conn->connect_error) {
            die("failed to connect with database " . $this->conn->connect_error);
        }
    }

    public function connect()
    {
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->database);
        if ($this->conn->connect_error) {
            die("failed to connect with database " . $this->conn->connect_error);
        } else {
            return $conn;
        }
    }

    public function query($sql)
    {
        $result = mysqli_query($this->conn, $sql);
        return $result;
    }

    public function select($table, $column = '*', $where = null)
    {
        if ($where != null) {
            $sql = "SELECT $column FROM $table WHERE $where";
        } else {
            $sql = "SELECT $column FROM $table";
        }
        $result = $this->query($sql);
        if ($result->num_rows > 0) {
            return $result;
        } else {
            return false;
        }
    }

    public function insert($table, $data, $where = null)
    {
        $columns = '';
        $values = '';
        $condition = '';
        foreach ($data as $column => $value) {
            $columns .= ($columns == '') ? $column : ", $column";
            $values .= ($values == '') ? "'$value'" : ", '$value'";
        }
        $sql = "INSERT INTO $table ($columns) VALUES ($values)";
        if (!empty($cond)) {
            foreach ($cond as $key => $value) {
                $condition .= "$key = '$value',";
            }
            $condition = rtrim($condition, ',');
            $sql .= " WHERE $condition";
        }
        $result = $this->query($sql);
        return $result;
    }

    public function update($table, $data, $where = null)
    {
        if ($where != null) {
            $sql = "UPDATE $table SET $data WHERE $where";
        } else {
            $sql = "UPDATE $table SET $data";
        }
        return $this->query($sql);
    }
}

?>