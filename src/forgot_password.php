<?php
include("connection/connect.php"); // Include the database connection file
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Include PHPMailer autoloader

session_start();

// Function to generate OTP
function generateOTP() {
    return mt_rand(100000, 999999);
}

if(isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    
    // Check if username exists in the database
    $query = "SELECT email FROM users WHERE username = '$username'";
    $result = mysqli_query($db, $query);
    if(mysqli_num_rows($result) > 0) {
        // Username exists, fetch the associated email
        $row = mysqli_fetch_assoc($result);
        $email = $row['email'];
        
        // Generate OTP
        $otp = generateOTP();
        
        // Store OTP in the database with timestamp
        $timestamp = time();
        $expiry_time = $timestamp + (60*5); // OTP expires in 5 minutes
        $query = "UPDATE users SET otp = '$otp', otp_expiry = '$expiry_time' WHERE email = '$email'";
        mysqli_query($db, $query);

        // Set session variables for OTP verification
        $_SESSION['reset_email'] = $email;
        $_SESSION['reset_expiry'] = $expiry_time;

        // Send OTP to user's email using PHPMailer
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com'; // SMTP server
            $mail->SMTPAuth   = true;
            $mail->Username = 'kushvaishnav234@gmail.com'; // Your Gmail username
            $mail->Password = 'bixzptrcnjjfkfzq'; // Your Gmail app password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587; // TCP port to connect to
            
            //Recipients
            $mail->setFrom('kushvaishnav234@gmail.com', 'UrbanKicks');
            $mail->addAddress($email); // Add a recipient
            
            //Content
            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject = 'Password Reset OTP';
            $mail->Body    = 'Your OTP is: ' . $otp;

            $mail->send();
            $success_message = 'An OTP has been sent to your email. Please check your inbox.';
            // Redirect to reset password page
            header("Location: reset_password.php");
            exit();
        } catch (Exception $e) {
            $error_message = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        // Username not found, display error message
        $error_message = "Username not found. Please enter a valid username.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
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
                            <h2>Forgot Password</h2>
                            <?php
                            if(isset($success_message)) {
                                echo '<p style="color:green;">' . $success_message . '</p>';
                            }
                            if(isset($error_message)) {
                                echo '<p style="color:red;">' . $error_message . '</p>';
                            }
                            ?>
                            <form method="post" action="">
                                <input type="text" id="username" name="username" placeholder="Enter your username" required><br><br>
                                <button type="submit" name="submit">Send OTP</button>
                            </form>

                            <?php if(isset($_POST['submit']) && isset($success_message)) { ?>
                            <hr>
                            <h2>Enter OTP</h2>
                            <form method="post" action="">
                                <input type="text" id="otp" name="otp" placeholder="Enter OTP" required><br><br>
                                <button type="submit" name="verify">Verify OTP</button>
                            </form>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
