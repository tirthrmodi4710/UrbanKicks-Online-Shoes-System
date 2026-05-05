<?php
session_start();
include("connection/connect.php");

if (!isset($_SESSION['otp']) || !isset($_SESSION['registration_data'])) {
    header("Location: registration.php");
    exit();
}

if (isset($_POST['verify'])) {
    $entered_otp = $_POST['otp'];
    $otp_from_session = $_SESSION['otp'];

    if ($entered_otp == $otp_from_session) {
        // OTP verification successful, proceed with registration
        $registration_data = $_SESSION['registration_data'];

        // Insert user data into database
        $username = $registration_data['username'];
        $firstname = $registration_data['firstname'];
        $lastname = $registration_data['lastname'];
        $email = $registration_data['email'];
        $phone = $registration_data['phone'];
        $password = $registration_data['password'];
        $address = $registration_data['address'];

        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Perform insertion query
        $query = "INSERT INTO users (username, f_name, l_name, email, phone, password, address, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $status = 1; // Set status to 1 for verified users
        $stmt = mysqli_prepare($db, $query);
        mysqli_stmt_bind_param($stmt, "sssssssi", $username, $firstname, $lastname, $email, $phone, $hashed_password, $address, $status);
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) > 0) {
            // Unset session variables
            unset($_SESSION['otp']);
            unset($_SESSION['registration_data']);

            header("Location: login.php?registration=success");
            exit();
        } else {
            $message = "Registration failed!";
        }
    } else {
        $message = "Invalid OTP!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="images/icon.png">
    <title>OTP Verification</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animsition.min.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <style>
        .transparent-input {
            background-color: white;
            border: none;
        }

        .text-center {
            color: white;
        }

        .form-control {
            border-radius: 10px;
        }

        .btn {
            border-radius: 10px;
        }
    </style>

</head>

<header id="header" class="header-scroll top-header headrom">
    <nav class="navbar navbar-dark">
        <div class="container">
            <button class="navbar-toggler hidden-lg-up" type="button" data-toggle="collapse"
                data-target="#mainNavbarCollapse">&#9776;</button>
            <a class="navbar-brand" href="index.php"> <img class="img-rounded" src="images/logo.png"
                    style="width: 150px" alt=""> </a>
            <div class="collapse navbar-toggleable-md  float-lg-right" id="mainNavbarCollapse">
                <ul class="nav navbar-nav">
                    <ul class="nav navbar-nav">
                        <li class="nav-item"> <a class="nav-link active" href="index.php">Home <span
                                    class="sr-only">(current)</span></a> </li>
                        <li class="nav-item"> <a class="nav-link active" href="category.php">Category<span
                                    class="sr-only"></span></a> </li>
                        <?php
                        if (empty($_SESSION["user_id"])) { // if user is not logged in
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

                </ul>
            </div>
        </div>
    </nav>
</header>

<body style="background-image: url('images/pattern.png'); background-size: cover; background-position: center; border-radius: 10px; padding: 20px;">
    <div class="page-wrapper">

        <section class="contact-page inner-page">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 offset-md-2">
                        <div class="widget" style="background-image: url('images/pattern.png'); background-size: cover; background-position: center; border-radius: 10px; padding: 20px;">
                            <div class="widget-body">
                                <h2 class="text-center mb-4">OTP Verification</h2>
                                <form method="post">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <input class="form-control transparent-input" type="text" name="otp" id="otp" placeholder="Enter OTP..." required>
                                        </div>
                                        <?php if (isset($message)) : ?>
                                            <div><?php echo $message; ?></div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <button type="submit" name="verify" class="btn btn-warning btn-block">Verify OTP</button>
                                        </div>
                                    </div>
                                </form>
                                <?php if (isset($message)) : ?>
                                    <div class="alert alert-danger"><?php echo $message; ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

</body>

<script src="js/jquery.min.js"></script>
<script src="js/tether.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/animsition.min.js"></script>
<script src="js/bootstrap-slider.min.js"></script>
<script src="js/jquery.isotope.min.js"></script>
<script src="js/headroom.js"></script>
<script src="js/foodpicky.min.js"></script>

</html>