<!-- <?php
session_start();
// namespace database;
class database
{
    var $host = "localhost";
    var $user = "root";
    var $pass = "";
    var $database = "db1";
    public $conn;
    function __construct()
    {
        $this->conn = mysqli_connect($this->host, $this->user, $this->pass, $this->database);
    }
    public function query($sql)
    {
        $result = mysqli_query($this->conn, $sql);
        return $result;
    }
    public function select($table = null, $data = '*', $cond = null)
    {
        if ($cond != null) {
            // $condition='';
            // foreach ($cond as $key => $value) {
            //     $condition .= "$key = '$value' AND ";
            // }
            // $condition=rtrim($condition,'AND');
            $sql = "SELECT $data FROM $table WHERE $cond";
        } else {
            $sql = "SELECT $data FROM $table";
        }
        $result = $this->query($sql);
        return $result;
    }
    public function insert($table, $data, $cond = null)
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
    public function update($table, $data, $cond = null)
    {
        $setClause = "";
        $condition = "";
        foreach ($data as $column => $value) {
            $setClause .= "$column = '$value', ";
        }
        foreach ($cond as $key => $value) {
            $condition .= "$key = '$value',";
        }
        $setClause = rtrim($setClause, ', '); // Remove the trailing comma
        $condition = rtrim($condition, ',');
        $sql = "UPDATE $table SET $setClause WHERE $condition";
        $result = $this->query($sql);
        return $result;
    }
}

$conn = new database;
?> -->