<?php
session_start();
include("connection/connect.php");
require "vendor/autoload.php"; // Include PHPMailer autoload file
use PHPMailer\PHPMailer\PHPMailer;

if (isset($_POST['submit'])) {
    // Check if all fields are filled
    if (empty($_POST['username']) || empty($_POST['firstname']) || empty($_POST['lastname']) || empty($_POST['email']) || empty($_POST['phone']) || empty($_POST['password']) || empty($_POST['cpassword']) || empty($_POST['address'])) {
        $message = "All fields must be Required!";
    } else {
        // Validate username, email, phone, password, etc.
        // Your existing validation code
        $check_username= mysqli_query($db, "SELECT username FROM users where username = '".$_POST['username']."' ");
	$check_email = mysqli_query($db, "SELECT email FROM users where email = '".$_POST['email']."' ");	
	if($_POST['password'] != $_POST['cpassword']){  	
    echo "<script>alert('Password not match');</script>"; 
    }
	elseif(strlen($_POST['password']) < 6)  
	{
      echo "<script>alert('Password Must be >=6');</script>"; 
	}
	elseif(strlen($_POST['phone']) < 10)  
	{
      echo "<script>alert('Invalid phone number!');</script>"; 
	}
    elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) 
    {
        echo "<script>alert('Invalid email address please type a valid email!');</script>"; 
    }
	elseif(mysqli_num_rows($check_username) > 0) 
     {
       echo "<script>alert('Username Already exists!');</script>"; 
     }
	elseif(mysqli_num_rows($check_email) > 0) 
     {
       echo "<script>alert('Email Already exists!');</script>"; 
     }

        // Generate OTP
        $otp = mt_rand(100000, 999999);

        // Send OTP via Email
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPSecure = 'tls';
        $mail->SMTPAuth = true;
        $mail->Username = 'kushvaishnav234@gmail.com'; // Your Gmail username
        $mail->Password = 'bixzptrcnjjfkfzq'; // Your Gmail app password
        $mail->setFrom('kushvaishnav234@gmail.com', 'UrbanKicks');
        $mail->addAddress($_POST['email']);
        $mail->Subject = 'OTP for Registration';
        $mail->Body = 'Your OTP for registration is: ' . $otp;

        if (!$mail->send()) {
            $message = 'Message could not be sent.';
            $message .= 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            $_SESSION['otp'] = $otp; // Store OTP in session
            $_SESSION['registration_data'] = $_POST; // Store registration data in session
            header("Location: verify_otp.php");
            exit();
        }
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
    <title>UrbanKicks</title>
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
    .text-center{
        color:white;
    }
    .form-control{
        border-radius:10px;
    }
    .btn{
        border-radius:10px;
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
    <div class="container">
        <!-- Your container code goes here -->
    </div>
    <section class="contact-page inner-page">
        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="widget" style="background-image: url('images/pattern.png'); background-size: cover; background-position: center; border-radius: 10px; padding: 20px;">
                        <div class="widget-body">
                            <h2 class="text-center mb-4">Create Your Account</h2>
                            <form action="" method="post">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <input class="form-control transparent-input" type="text" name="username" placeholder="User Name" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <input class="form-control transparent-input" type="text" name="firstname" placeholder="First Name" value="<?php echo isset($_POST['firstname']) ? $_POST['firstname'] : ''; ?>" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <input class="form-control transparent-input" type="text" name="lastname" placeholder="Last Name" value="<?php echo isset($_POST['lastname']) ? $_POST['lastname'] : ''; ?>" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <input class="form-control transparent-input" type="email" name="email" placeholder="Email Address" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <input class="form-control transparent-input" type="tel" name="phone" placeholder="Phone Number" value="<?php echo isset($_POST['phone']) ? $_POST['phone'] : ''; ?>" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <input class="form-control transparent-input" type="password" name="password" placeholder="Password" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <input class="form-control transparent-input" type="password" name="cpassword" placeholder="Confirm Password" required>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <textarea class="form-control transparent-input" name="address" placeholder="Delivery Address" rows="3"><?php echo isset($_POST['address']) ? $_POST['address'] : ''; ?></textarea required >
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <button type="submit" name="submit" class="btn btn-warning btn-block">Register</button>
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