<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $showAlert = false;
    $showError = false;
    include 'partials/_dbconnect.php';
    $username = $_POST["username"];
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];
    // $exists = false;


    // check Whether this username Exists
    $existSql = "SELECT * FROM `users` WHERE username='$username'";
    $result = mysqli_query($conn, $existSql);
    $numExistRows = mysqli_num_rows($result);
    if ($numExistRows > 0) {
        // $exists=true;
        $showError = " Username Already Exists ";
    } 
    else {
        // $exists=false;
        if (($password == $cpassword)) {
            $hash=password_hash($password,PASSWORD_DEFAULT);
            $sql = "INSERT INTO `users` (`username`, `password`, `dt`) VALUES ('$username', '$hash', current_timestamp());";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                $showAlert = true;
            }
        } 
        else {
            $showError = "Passwords do not match.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <style>
        body {
            background-color: bisque;
        }

        h1 {
            color: blue;
            text-decoration: underline;
        }

        label {
            color: red;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        input {
            background-color: green;
        }
    </style>
</head>

<body>
    <?php require("partials/__nav.php") ?>
    <?php
    error_reporting(0);
    if ($showAlert) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> Your Account is now created You can Login
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    }
    if ($showError) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong>' . $showError .
            '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    }
    ?>
    <div class="container my-5">
        <h1 class="text-center ">Sign Up To Our Website</h1>
        <form action="../loginSystem/signup.php" method="post">
            <div class="mb-3 col-md-6">
                <label for="username" class="form-label">UserName</label>
                <input type="text" class="form-control" id="username" name="username" aria-describedby="emailHelp" placeholder="UserName" required>
            </div>
            <div class="mb-3 col-md-6">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="password" maxlength="8" required>
            </div>
            <div class="mb-3 col-md-6">
                <label for="cpassword" class="form-label">Confirm Password</label>
                <input type="password" class="form-control " id="cpassword" name="cpassword" placeholder="confirm password" required>
                <div id="emailHelp" class="form-text">Make sure to type the same password.</div>
            </div>
            <button type="submit" class="btn btn-primary col-md-6">Signup</button>
        </form>
    </div>

</body>

</html>