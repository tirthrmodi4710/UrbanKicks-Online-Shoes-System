<!DOCTYPE html>
<html lang="en">
<?php
include("connection/connect.php");  
error_reporting(0);  
session_start(); 
?>

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
    /* Add custom CSS for larger and white icons */
    .step-item i {
        font-size: 2em;
        color: white;
        padding: 20px;
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
                            if(empty($_SESSION["user_id"])) // if user is not logged in
                            {
                                echo '<li class="nav-item"><a href="login.php" class="nav-link active">Login</a> </li>';
                                echo '<li class="nav-item"><a href="registration.php" class="nav-link active">Register</a> </li>';
                            }
                            else
                            {
                                echo '<li class="nav-item"><a href="your_orders.php" class="nav-link active">My Orders</a> </li>';
                                echo '<li class="nav-item"><a href="logout.php" class="nav-link active">Logout</a> </li>';
                                // Fetch the username from the database based on the user's ID
                                $user_id = $_SESSION["user_id"];
                                $query = "SELECT username FROM users WHERE u_id = $user_id";
                                $result = mysqli_query($db, $query);
                                if($result && mysqli_num_rows($result) > 0) {
                                    $row = mysqli_fetch_assoc($result);
                                    $username = $row['username'];
                                    echo '<li class="nav-item fw-bold text-primary"><a href="user_details.php" class="nav-link active">Welcome '.$username.'</a></li>';

                                } else 
                                {
                                    // Handle the case where the user is logged in but their information cannot be fetched
                                }
                            }
                        ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <section class="hero bg-image" data-image-src="images/img/cover.jpg">
        <div class="hero-inner">
            <div class="container text-center hero-text font-black">
                <div class="banner-form">
                    <form class="form-inline">
                        <h1>Get Your Shoes here!!</h1>
                    </form>

                </div>
                <div class="steps">
                    <div class="step-item step1">
                        <i class="fas fa-list-alt fa-fw fa-2x"></i>
                        <h4><span style="color:white;">1. </span>Choose Category</h4>
                    </div>
                    <div class="step-item step2">
                        <i class="fas fa-shopping-cart fa-fw fa-2x"></i>
                        <h4><span style="color:white;">2. </span>Order Shoe</h4>
                    </div>
                    <div class="step-item step3">
                        <i class="fas fa-box-open fa-fw fa-2x"></i>
                        <h4><span style="color:white;">3. </span>Receive Shoes</h4>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div id="searchResults"></div>
    <div class="result-show">

    </div>
</div>
    <section class="restaurants-page border">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-5 col-md-5 col-lg-3">
                    <div style="position: relative;">
                        <img src="images/list.jpg" alt="Featured Image" style="width: 100%;">
                        <div
                            style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: white; text-align: center;">
                            <h2 style="font-size: 30px; font-weight: bold;">Category of Shoes</h2>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-7 col-md-7 col-lg-9">
                    <div class="bg-gray restaurant-entry">
                        <div class="row">
                            <?php
                    $ress = mysqli_query($db, "select * from category");
                    while ($rows = mysqli_fetch_array($ress)) {
                        echo '<div class="col-sm-12 col-md-12 col-lg-8">
                                    <div class="entry-logo">
                                        <a class="img-fluid" href="products.php?res_id='.$rows['rs_id'].'">
                                            <img src="admin/Res_img/'.$rows['image'].'" alt="Food logo">
                                        </a>
                                    </div>
                                    <div class="entry-dscr">
                                        <h5><a href="products.php?res_id='.$rows['rs_id'].'">'.$rows['title'].'</a></h5>
                                        <span>'.$rows['address'].'</span>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-4">
                                    <div class="right-content bg-white">
                                        <div class="right-review">
                                            <a href="products.php?res_id='.$rows['rs_id'].'" class="btn btn-primary">View Products</a>
                                        </div>
                                    </div>
                                </div>';
                    }
                    ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="popular">
        <div class="container">
            <div class="title text-xs-center m-b-30">
                <h2>Popular Products of the Month</h2>
                <p class="lead">Easiest way to order your favourite Shoe among these top 6 Shoes</p>
            </div>
            <div class="row">
                <?php 					
						$query_res= mysqli_query($db,"SELECT * FROM Product ORDER BY RAND() LIMIT 6;
"); 
                                while($r=mysqli_fetch_array($query_res))
                                {      
                                    echo '  <div class="col-xs-12 col-sm-6 col-md-4 food-item">
                                            <div class="food-item-wrap">
                                                <div class="figure-wrap bg-image" data-image-src="admin/Res_img/dishes/'.$r['img'].'"></div>
                                                <div class="content">
                                                    <h5><a href="products.php?res_id='.$r['rs_id'].'">'.$r['title'].'</a></h5>
                                                    <div class="product-name">'.$r['slogan'].'</div>
                                                    <div class="price-btn-block"> <span class="price">₹'.$r['price'].'</span> <a href="products.php?res_id='.$r['rs_id'].'" class="btn btn-primary pull-right">Order Now</a> </div>
                                                </div>
                                                
                                            </div>
                                    </div>';                                      
                                }	
						?>
            </div>
        </div>
    </section>
    <footer class="footer">
        <div class="container">
            <div class="bottom-footer">
                <div class="row">
                    <div class="col-xs-12 col-sm-3 payment-options color-gray">
                        <h5>Payment Options</h5>
                        <ul>
                            <li>
                                <a href="#"> <img src="images/razorpay.jpg" alt="Paypal"> </a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-xs-12 col-sm-4 address color-gray">
                        <h5>Address</h5>
                        <p>S. V. Institurte of Computer Studies, Gandhinagar, Gujarat</p>
                        <h5>Phone : +91 851 1060 234</h5>
                    </div>
                    <div class="col-xs-12 col-sm-5 additional-info color-gray">
                        <h5>Addition informations</h5>
                        <p>Join thousands of other shoe enthusiasts who benefit from partnering with us for your
                            footwear needs.</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <script src="js/jquery.min.js"></script>
    <script src="js/tether.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/animsition.min.js"></script>
    <script src="js/bootstrap-slider.min.js"></script>
    <script src="js/jquery.isotope.min.js"></script>
    <script src="js/headroom.js"></script>
    <script src="js/foodpicky.min.js"></script>
</body>

</html>