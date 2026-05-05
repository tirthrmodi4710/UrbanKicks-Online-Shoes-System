<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="images/icon.png">
    <title>UrbanKicks - Search Results</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* Custom CSS for search results */
        body {
            background-color: #f8f9fa;
        }

        .search-results {
            padding: 60px 0;
        }

        .result-item {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            margin-bottom: 30px;
        }

        .result-item:hover {
            box-shadow: 0px 0px 20px 0px rgba(0, 0, 0, 0.2);
        }

        .result-item img {
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            max-width: 100%;
        }

        .result-item .details {
            padding: 20px;
        }

        .result-item h3 {
            margin-top: 0;
            font-size: 18px;
            color: #333;
        }

        .result-item p {
            margin-bottom: 10px;
            font-size: 14px;
            color: #666;
        }

        .result-item .price {
            font-size: 16px;
            color: #007bff;
            font-weight: bold;
        }

        .result-item .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .result-item .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .footer {
            background-color: #343a40;
            color: #fff;
            padding: 30px 0;
        }

        .footer h5 {
            color: #fff;
            margin-top: 0;
        }

        .footer p {
            color: #ccc;
        }
    </style>
</head>

<body>
    <header id="header" class="header-scroll top-header headrom">
        <nav class="navbar navbar-dark">
            <div class="container">
                <a class="navbar-brand" href="index.php"> <img class="img-rounded" src="images/logo.png" alt="UrbanKicks"
                        style="width: 150px"> </a>
                <div class="collapse navbar-toggleable-md float-lg-right" id="mainNavbarCollapse">
                    <ul class="nav navbar-nav">
                        <li class="nav-item">
                            <form method="GET" action="search.php" class="form-inline">
                                <input type="text" name="query" placeholder="Search for shoes..."
                                    class="form-control mr-sm-2">
                               <button type="submit" class="btn btn-outline-light"><i class="fas fa-search"></i></button>
<button type="button" class="btn btn-outline-light" onclick="clearResults()"><i class="fas fa-times"></i></button>

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
                                    echo '<li class="nav-item fw-bold text-primary"><a href=#" class="nav-link active">Welcome '.$username.'</a> </li>';
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

    <section class="search-results">
        <div class="container">
            <?php
            include("connection/connect.php");

            if(isset($_GET['query'])) {
                $search_query = $_GET['query'];
                $sql = "SELECT * FROM Product WHERE title LIKE '$search_query%'";
                $result = mysqli_query($db, $sql);

                if(mysqli_num_rows($result) > 0) {
        echo "<h2>Search Results:</h2>";
        echo "<div class='row'style='padding: 10px; margin-bottom: 10px;'>";
        while($row = mysqli_fetch_assoc($result)) {
            echo "<div class='col-md-4 result-item' style='padding: 10px; margin-bottom: 10px;'>";
            echo "<div style='width: 100%; height: 300px; overflow: hidden;'>";
            echo "<img src='admin/Res_img/dishes/{$row['img']}' alt='{$row['title']}' style='max-width: 100%;'>";
            echo "</div>";
            echo "<div style='padding: 10px; border-top: 1px solid #ccc; background-color: #f9f9f9;'>";
            echo "<h3>{$row['title']}</h3>";
            echo "<p>{$row['slogan']}</p>";
            echo "<p>Price: ₹{$row['price']}</p>";
            echo "<a href='products.php?res_id={$row['rs_id']}' class='btn btn-primary'>Order Now</a>";
            echo "</div>";
            echo "</div>";
        }
        echo "</div>";
    } else {
        echo "<p>No results found</p>";
    }
}
            ?>
        </div>
    </section>

    <footer class="footer">
        <div class="container">
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
                    <p>S. V. Institute of Computer Studies, Gandhinagar, Gujarat</p>
                    <h5>Phone : +91 851 1060 234</h5>
                </div>
                <div class="col-xs-12 col-sm-5 additional-info color-gray">
                    <h5>Additional Information</h5>
                    <p>Join thousands of other shoe enthusiasts who benefit from partnering with us for your footwear needs.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>
        function clearResults() {
            window.location.href = 'index.php';
        }
    </script>
</body>

</html>