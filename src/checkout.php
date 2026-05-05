<!DOCTYPE html>
<html lang="en">
<?php
include("connection/connect.php");
include_once 'product-action.php';
error_reporting(0);
session_start();

if (empty($_SESSION["user_id"])) {
    header('location:login.php');
} else {
    foreach ($_SESSION["cart_item"] as $item) {
        $item_total += ($item["price"] * $item["quantity"]);
        if ($_POST['submit']) {
            $SQL = "INSERT INTO users_orders (u_id, title, quantity, shoe_size, price, payment_method) VALUES ('" . $_SESSION["user_id"] . "', '" . $item["title"] . "', '" . $item["quantity"] . "', '" . $item["size"] . "', '" . $item["price"] . "', 'COD')";
            mysqli_query($db, $SQL);
            unset($_SESSION["cart_item"]);
            $success = "Thank you. Your order has been placed!";
            header("location:your_orders.php");
        }
    }
}
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
</head>

<body>

    <div class="site-wrapper">
        <header id="header" class="header-scroll top-header headrom">
            <nav class="navbar navbar-dark">
                <div class="container">
                    <button class="navbar-toggler hidden-lg-up" type="button" data-toggle="collapse"
                        data-target="#mainNavbarCollapse">&#9776;</button>
                    <a class="navbar-brand" href="index.php"> <img class="img-rounded" src="images/logo.png"
                            style="width: 150px" alt="">
                    </a>
                    <div class="collapse navbar-toggleable-md  float-lg-right" id="mainNavbarCollapse">
                        <ul class="nav navbar-nav">
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
        <div class="page-wrapper">
            <div class="top-links">
                <div class="container">
                    <ul class="row links">
                        <li class="col-xs-12 col-sm-4 link-item"><span>1</span><a href="#">Choose
                                Category</a></li>
                        <li class="col-xs-12 col-sm-4 link-item "><span>2</span><a href="#">Pick Your favorite Shoes</a>
                        </li>
                        <li class="col-xs-12 col-sm-4 link-item active"><span>3</span><a href="checkout.php">Order and
                                Pay</a></li>
                    </ul>
                </div>
            </div>

            <div class="container">
                <span style="color:green;"><?php echo $success; ?></span>
            </div>

            <div class="container m-t-30">
                <form action="" method="post">
                    <div class="widget clearfix">
                        <div class="widget-body">
                            <form method="post" action="#">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="cart-totals margin-b-20">
                                            <div class="cart-totals-title">
                                                <h4>Cart Summary</h4>
                                            </div>
                                            <div class="cart-totals-fields">
                                                <table class="table">
                                                    <tbody>
                                                        <tr>
                                                            <td>Product</td>
                                                            <td>Quantity</td>
                                                            <td>Size</td>
                                                            <!-- Add this line to display the shoe size -->
                                                            <td>Price</td>
                                                        </tr>
                                                        <?php
                                                        foreach ($_SESSION["cart_item"] as $item) {
                                                        ?>
                                                            <tr>
                                                                <td><?php echo $item["title"]; ?></td>
                                                                <td><?php echo $item["quantity"]; ?></td>
                                                                <td><?php echo $item["size"]; ?></td>
                                                                <!-- Display the selected shoe size -->
                                                                <td><?php echo "₹" . $item["price"]; ?></td>
                                                            </tr>
                                                        <?php
                                                        }
                                                        ?>
                                                        <tr>
                                                            <td>Cart Subtotal</td>
                                                            <td> <?php echo "₹" . $item_total; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Delivery Charges</td>
                                                            <td>Free</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-color"><strong>Total</strong></td>
                                                            <td class="text-color"><strong>
                                                                    <?php echo "₹" . $item_total; ?></strong></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="payment-option">
                                            <form method="POST" action="">
                                                <ul class="list-unstyled">
                                                    <li>
                                                        <label class="custom-control custom-radio m-b-20">
                                                            <input name="payment_method" id="COD" checked value="COD" type="radio" class="custom-control-input">

                                                            <span class="custom-control-indicator"></span>
                                                            <span class="custom-control-description">Cash on Delivery</span>
                                                        </label>
                                                    </li>
                                                </ul>
                                                <p class="text-xs-center">
                                                    <input type="submit" onclick="return confirm('Do you want to confirm the order?');" name="submit" class="btn btn-success btn-block" value="Order Now">
                                                </p>
                                            </form>
                                            <input type="hidden" name="amount" value="<?php echo $item_total; ?>">
                                            <div class="custom-control custom-radio m-b-10">

                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Razorpay Payment Button -->

            <button id="rzp-button" class="btn btn-success btn-block">Pay with Razorpay</button>


        </div>
    </div>
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

    <!-- Add Razorpay checkout script with your API key -->
    <!-- Your HTML code -->

    <!-- Add Razorpay checkout script with your API key -->
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>


    <script>
        // Create a Razorpay payment object
        var options = {
            key: 'rzp_test_WCHM36KbK3Q91y',
            amount: <?php echo $item_total * 100;  ?>, // amount in paisa
            currency: 'INR',
            name: 'UrbanKicks',
            description: 'Payment for Order',
            handler: function(response) {
                // Handle payment success
                alert('Payment successful!');
                // Redirect to a thank you page or handle success as per your requirement
                window.location.href = 'payment_success.php?order=done';
            }
        };

        document.getElementById('rzp-button').onclick = function(e) {
            // Open Razorpay checkout form
            var rzp = new Razorpay(options);
            rzp.open();
            e.preventDefault();
        }
    </script>

</body>

</html>