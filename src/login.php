<?php
session_start();

include("connection/connect.php");
error_reporting(0);
session_start();
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (!empty($_POST["submit"])) {
        $loginquery = "SELECT * FROM users WHERE username='$username'"; // select matching records
        $result = mysqli_query($db, $loginquery); // executing

        if ($row = mysqli_fetch_assoc($result)) {
            if (password_verify($password, $row['password'])) {
                $_SESSION["user_id"] = $row['u_id'];
                header("Location: index.php");
                exit();
            } else {
                $message = "Invalid Password!";
            }
        } else {
            $message = "Invalid Username!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="images/icon.png">
    <title>UrbanKicks</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
    <link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900|RobotoDraft:400,100,300,500,700,900'>
    <link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>
    <link rel="stylesheet" href="css/login.css">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animsition.min.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <style type="text/css">
        #buttn {
            color: #fff;
            background-color: #5c4ac7;
        }

        .transparent-input {
            background-color: white;
            border: 1px solid;
            border-radius: 5px;
        }

        .text-center {
            color: white;
        }

        input {
            border-radius: 10%;
        }

        .btn {
            border-radius: 5px;
        }

        img {
            border-radius: 5px;
            margin-bottom: 10px;
        }
    </style>
</head>

<header id="header" class="header-scroll top-header headrom">
    <nav class="navbar navbar-dark">
        <div class="container">
            <button class="navbar-toggler hidden-lg-up" type="button" data-toggle="collapse" data-target="#mainNavbarCollapse">&#9776;</button>
            <a class="navbar-brand" href="index.php"> <img class="img-rounded" src="images/logo.png" style="width: 150px" alt=""> </a>
            <div class="collapse navbar-toggleable-md  float-lg-right" id="mainNavbarCollapse">
                <ul class="nav navbar-nav">
                    <li class="nav-item"> <a class="nav-link active" href="index.php">Home <span class="sr-only">(current)</span></a> </li>
                    <li class="nav-item"> <a class="nav-link active" href="category.php">Category <span class="sr-only"></span></a> </li>
                    <?php
                    if (empty($_SESSION["user_id"])) // if user is not logged in
                    {
                        echo '<li class="nav-item"><a href="login.php" class="nav-link active">Login</a> </li>';
                        echo '<li class="nav-item"><a href="registration.php" class="nav-link active">Register</a> </li>';
                    } else {
                        echo '<li class="nav-item"><a href="your_orders.php" class="nav-link active">My Orders</a> </li>';
                        echo '<li class="nav-item"><a href="logout.php" class="nav-link active">Logout</a> </li>';
                        // Fetch the username from the database based on the user's ID
                        $user_id = $_SESSION["user_id"];
                        $query = "SELECT username FROM users WHERE u_id = $user_id";
                        $result = mysqli_query($db, $query);
                        if ($result && mysqli_num_rows($result) > 0) {
                            $row = mysqli_fetch_assoc($result);
                            $username = $row['username'];
                            echo '<li class="nav-item fw-bold text-primary"><a href="#" class="nav-link active">Welcome ' . $username . '</a> </li>';
                        } else {
                            // Handle the case where the user is logged in but their information cannot be fetched
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav>
</header>

<body style="background-image: url('images/pattern.png'); background-size: cover; background-position: center;">
    <div class="pen-title">
    </div>
    <section class="contact-page inner-page">
        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="module form-module" style="background-color: rgba(255, 255, 255, 0.7); border-radius: 10px; padding: 20px;">
                        <div class="toggle"></div>
                        <div class="form">
                            <h2>Login to your account</h2>
                            <span style="color:red;"><?php echo isset($message) ? $message : ''; ?></span>
                            <form action="" method="post">
                                <input type="text" placeholder="Username" name="username" class="form-control transparent-input" required />
                                <input type="password" placeholder="Password" name="password" class="form-control transparent-input" required />
                                <input type="submit" value="Login" name="submit" class="btn btn-warning btn-block" />
                            </form>
                        </div>
                        <div class="">Not registered? <a href="registration.php" class="text-primary">Create an account</a>
                        </div>
                        <div class="">Forgot the Password! <a href="forgot_password.php" class="text-primary"> Forgot Password?</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

</html>