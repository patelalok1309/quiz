<?php
session_start();
include("./database_connection.php");
include("./alert.php");

$loginerror = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM `users` WHERE `username`='$username' AND `password`='$password'";
    $result = mysqli_query($conn, $sql);

    if ($result->num_rows != 0) {
        $loginSuccess = true;
        $row = $result->fetch_assoc();
        $_SESSION["username"] = $row['username'];
        $_SESSION['sno'] = $row['sno'];
        $_SESSION['role'] = $row['role'];
        header("Location: /cwh/quiz/index.php", true);
    } else {
        $loginerror = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz - login</title>
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
    <?php include("./navbar.php"); ?>

    <?php
    if ($loginerror) {
        alert("danger", "Problem in Logging in! Please check username and password");
    }
    ?>
    <div class="container d-flex justify-content-center align-items-center ">
        <form action="/cwh/quiz/components/login.php" method="post" class="col-md-6">
            <fieldset>
                <legend>
                    <h1 class="text-center">Login</h1>
                </legend>
                <div class="form-group">
                    <label for="username" class="text-center" required>Username</label>
                    <input type="text" name="username" id="username" class="form-control">
                </div>
                <div class="form-group">
                    <label for="password" class="text-center" required>Password</label>
                    <input type="password" name="password" id="password" class="form-control">
                </div>
                <button class="btn btn-primary mt-3 ">Submit</button>
            </fieldset>
        </form>
    </div>

</body>

</html>