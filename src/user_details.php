<?php
include("connection/connect.php");
session_start();

if (empty($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST["update"])) {
    $user_id = $_SESSION["user_id"];
    $username = mysqli_real_escape_string($db, $_POST["username"]);
    $email = mysqli_real_escape_string($db, $_POST["email"]);
    $fname = mysqli_real_escape_string($db, $_POST["fname"]);
    $lname = mysqli_real_escape_string($db, $_POST["lname"]);
    $phone = mysqli_real_escape_string($db, $_POST["phone"]);
    $address = mysqli_real_escape_string($db, $_POST["address"]);

    $query = "UPDATE users SET username='$username', email='$email', f_name='$fname', l_name='$lname', phone='$phone', address='$address' WHERE u_id = $user_id";
    $result = mysqli_query($db, $query);

    if ($result) {
        // Redirect to user profile page with success message
        header("Location: user_details.php?success=1");
        exit();
    } else {
        // Redirect to user profile page with error message
        header("Location: user_details.php?error=1");
        exit();
    }
}

// Fetch user details based on user ID from session
$user_id = $_SESSION["user_id"];
$query = "SELECT * FROM users WHERE u_id = $user_id";
$result = mysqli_query($db, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
    // Assign user details to variables
    $username = $user['username'];
    $email = $user['email'];
    $user_fname = $user['f_name'];
    $user_lname = $user['l_name'];
    $phone = $user['phone'];
    $address = $user['address'];
} else {
    echo "User details not found!";
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
    <title>User Details</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animsition.min.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* Add custom CSS for larger and white icons */
        .input {}

        .step-item i {
            font-size: 2em;
            color: white;
            padding: 20px;
        }

        .card-header {
            margin-top: 10%;
        }

        .transparent-input {
            background-color: white;
            border: 1px solid wheat;

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

<body class="home">

    <header id="header" class="header-scroll top-header headrom">
        <nav class="navbar navbar-dark">
            <div class="container">
                <button class="navbar-toggler hidden-lg-up" type="button" data-toggle="collapse"
                    data-target="#mainNavbarCollapse">&#9776;</button>
                <a class="navbar-brand" href="index.php"> <img class="img-rounded" src="images/logo.png" alt="kush"
                        style="width: 150px"> </a>
                <div class="collapse navbar-toggleable-md  float-lg-right" id="mainNavbarCollapse">
                    <ul class="nav navbar-nav">
                        <li class="nav-item">
                            <form method="GET" action="search.php" class="form-inline">
                                <input type="text" name="query" placeholder="Search for shoes..."
                                    class="form-control mr-sm-2">
                                <button type="submit" class="btn btn-outline-light"><i class="fas fa-search"></i></button>

                            </form>
                        </li>
                        <li class="nav-item"> <a class="nav-link active" href="index.php">Home <span
                                    class="sr-only">(current)</span></a> </li>
                        <li class="nav-item"> <a class="nav-link active" href="category.php">Category<span
                                    class="sr-only"></span></a> </li>
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
                            $query = "SELECT * FROM users WHERE u_id = $user_id";
                            $result = mysqli_query($db, $query);
                            if ($result && mysqli_num_rows($result) > 0) {
                                $row = mysqli_fetch_assoc($result);
                                $username = $row['username'];
                                echo '<li class="nav-item fw-bold text-primary"><a href="user_details.php" class="nav-link active">Welcome ' . $username . '</a></li>';
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

    <div class="container">
        <!-- User Details Section -->
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h2>User Details</h2>
                    </div>
                    <div class="card-body" style="margin: 10px;">
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <p><strong>Username:</strong> <input type="text" class="form-control transparent-input" name="username" value="<?php echo $username; ?>"></p>
                            <p><strong>Email:</strong> <input type="email" class="form-control transparent-input" name="email" value="<?php echo $email; ?>"></p>
                            <p><strong>First Name:</strong> <input type="text" class="form-control transparent-input" name="fname" value="<?php echo $user_fname; ?>"></p>
                            <p><strong>Last Name:</strong> <input type="text" class="form-control transparent-input" name="lname" value="<?php echo $user_lname; ?>"></p>
                            <p><strong>Phone:</strong> <input type="text" class="form-control transparent-input" name="phone" value="<?php echo $phone; ?>"></p>
                            <p><strong>Address:</strong> <input type="text" class="form-control transparent-input" name="address" value="<?php echo $address; ?>"></p>
                            <input type="submit" name="update" class="btn btn-warning btn-block" value="Update">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>

</html>