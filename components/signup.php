<?php
include("../classes/Database.php");
include("./alert.php");
include("../classes/users.php");
$user = new Users();

$db = new DatabaseConnection("localhost", "root", "", "quiz");
$conn = $db->connect();

$signUpError = false;
$signUpSuccess = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $cpassword = $_POST['cpassword'];

    if (($cpassword != $password) or (mysqli_num_rows($conn->query("SELECT * FROM `users` WHERE username='$username'")) > 0)) {
        $signUpError = true;
    } else {
        $user->insertNewUser($conn, $username, $password, $email);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz - Signup</title>
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
    if ($signUpError) {
        echo alert("danger", "Problem in creating accound");
    }
    if ($signUpSuccess) {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'> 
                <strong> Congrats! </strong>
               $username Your account successfully registered... redirecting to login page
                <button type='button' class='close btn-close ' data-bs-dismiss='alert' aria-label='close'>
                <span aria-hidden='true'>  </span>
                </button> 
                 </div>";
    }
    ?>
    <div class="container d-flex justify-content-center align-items-center ">
        <form action="/quiz/components/signup.php" method="post" class="col-md-6">
            <fieldset>
                <legend>
                    <h1 class="text-center">Signup</h1>
                </legend>
                <div class="form-group">
                    <label for="username" class="text-center" required>Username</label>
                    <input type="text" name="username" id="username" class="form-control">
                </div>
                <div class="form-group">
                    <label for="email" class="text-center" required>Email</label>
                    <input type="email" name="email" id="email" class="form-control">
                </div>
                <div class="form-group">
                    <label for="password" class="text-center" required>Password</label>
                    <input type="password" name="password" id="password" class="form-control">
                </div>
                <div class="form-group">
                    <label for="cpassword" class="text-center" required>Confirm Password</label>
                    <input type="password" name="cpassword" id="cpassword" class="form-control">
                </div>
                <button class="btn btn-primary mt-3 ">Submit</button>
            </fieldset>
        </form>
    </div>

</body>

</html>