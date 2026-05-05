    <?php
include("connection/connect.php"); // Include the database connection file

session_start();

// Redirect if reset email is not set or expired
if(!isset($_SESSION['reset_email']) || $_SESSION['reset_expiry'] < time()) {
    unset($_SESSION['reset_email']);
    unset($_SESSION['reset_expiry']);
    header("Location: forgot_password.php?expired=true");
    exit();
}

if(isset($_POST['submit'])) {
    // Check if OTP is submitted
    if(isset($_POST['otp'])) {
        $entered_otp = mysqli_real_escape_string($db, $_POST['otp']);
        $email = $_SESSION['reset_email'];
        
        // Retrieve OTP and its expiry time from the database
        $query = "SELECT otp, otp_expiry FROM users WHERE email = '$email'";
        $result = mysqli_query($db, $query);
        $row = mysqli_fetch_assoc($result);
        
        // Check if OTP matches and is not expired
        if($row && $row['otp'] == $entered_otp && $row['otp_expiry'] >= time()) {
            // Proceed to reset password
            // Display the password reset form
            ?>
<!DOCTYPE html>
<html lang="en">
<head>
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
        border-radius:5px;
        }
        .text-center{
        color:white;
        }
        input{
            border-radius:10%;
        }
        .btn{
        border-radius:5px;
        }
        img{
        border-radius:5px;
        margin-bottom:10px;
        }
    </style>
</head>
<body style="background-image: url('images/pattern.png'); background-size: cover; background-position: center;">
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

<div class="pen-title"></div>
<section class="contact-page inner-page">
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="module form-module" style="background-color: rgba(255, 255, 255, 0.7); border-radius: 10px; padding: 20px;">
                    <div class="toggle"></div>
                    <div class="form">
                        <h2>Reset Password</h2>
                        <?php
                        if(isset($error_message)) {
                            echo '<p style="color:red;">' . $error_message . '</p>';
                        }
                        ?>
                        <form method="post" action="">
                            <label for="new_password">New Password:</label><br>
                            <input type="password" id="new_password" name="new_password" required><br><br>
                            <label for="confirm_password">Confirm Password:</label><br>
                            <input type="password" id="confirm_password" name="confirm_password" required><br><br>
                            <button type="submit" name="reset">Reset Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</body>
</html>

            <?php
            // No need to unset session variables here as the reset process is still ongoing
            exit();
        } else {
            // If OTP is incorrect or expired, display an error message
            $error_message = "Invalid or expired OTP. Please try again.";
        }
    } else {
        // If OTP is not submitted, display an error message
        $error_message = "Please enter the OTP.";
    }
}

if(isset($_POST['reset'])) {
    // Proceed with resetting the password (similar to your existing code)
    $new_password = mysqli_real_escape_string($db, $_POST['new_password']);
    $confirm_password = mysqli_real_escape_string($db, $_POST['confirm_password']);
    
    // Validate passwords
    if($new_password !== $confirm_password) {
        $error_message = "Passwords do not match.";
    } else {
        // Check password strength
        if(strlen($new_password) < 8) {
            $error_message = "Password must be at least 8 characters long.";
        } else {
            // Update password in the database
            $email = $_SESSION['reset_email'];
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT); // Hash the password before storing
            $query = "UPDATE users SET password = '$hashed_password', otp = NULL, otp_expiry = NULL WHERE email = '$email'";
            mysqli_query($db, $query);
            
            // Reset session variables
            unset($_SESSION['reset_email']);
            unset($_SESSION['reset_expiry']);
            
            // Redirect to login page
            header("Location: login.php?reset=true");
            exit();
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
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
        border-radius:5px;
        }
        .text-center{
        color:white;
        }
        input{
            border-radius:10%;
        }
        .btn{
        border-radius:5px;
        }
        img{
        border-radius:5px;
        margin-bottom:10px;
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
    <div class="pen-title"></div>
    <section class="contact-page inner-page">
        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="module form-module" style="background-color: rgba(255, 255, 255, 0.7); border-radius: 10px; padding: 20px;">
                        <div class="toggle"></div>
                        <div class="form">
                            <h2>Reset Password</h2>
                            <?php
                            if(isset($error_message)) {
                                echo '<p style="color:red;">' . $error_message . '</p>';
                            }
                            ?>
                            <form method="post" action="">
                                <label for="otp">Enter OTP:</label><br>
                                <input type="text" id="otp" name="otp" required><br><br>
                                <button type="submit" name="submit">Submit OTP</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>

