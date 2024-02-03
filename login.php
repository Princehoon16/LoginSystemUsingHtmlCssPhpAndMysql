<?php
 $login = false;
 $showError = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'partials/_dbconnect.php';
    $username = $_POST["username"];
    $password = $_POST["password"];


    // $sql = "Select * from users where username ='$username' AND password='$password'";
    $sql = "Select * from users where username ='$username'";

    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);
    if ($num == 1) {
        while ($row = mysqli_fetch_assoc($result)) {
            if (password_verify($password, $row['password'])) {
                $login = true;
                session_start();
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $username;
                header("location:welcome.php");
            }
            else{
                $showError="invalid Credentials";
            }
        }
    } 
    else {
        $showError = "invalid Credentials";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <style>
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            border: 2px solid black;
        }

        body {
            background-color: white;
        }

        h1 {
            color: green;
        }

        label {
            color: green;
        }
    </style>
</head>

<body>
    <?php require("partials/__nav.php") ?>
    <?php
    error_reporting(0);
    if ($login) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> You Are Logged in
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
        <h1 class="text-center">Login</h1>
        <form action="../loginSystem/login.php" method="post" class="border border-danger p-5 ">
            <div class="mb-3 col-md-6">
                <label for="username" class="form-label">UserName</label>
                <input type="text" class="form-control" id="username" name="username" aria-describedby="emailHelp" placeholder="UserName" required>

            </div>
            <div class="mb-3 col-md-6">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="password" required>
            </div>


            <button type="submit" class="btn btn-success col-md-6">Login</button>
        </form>
    </div>

</body>

</html>