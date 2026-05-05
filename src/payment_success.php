<?php
include("connection/connect.php");
include_once 'product-action.php';
error_reporting(0);
session_start();

if(empty($_SESSION["user_id"]))
{
	header('location:login.php');
}
else {
    // Check if the cart is not empty
    if(!empty($_SESSION["cart_item"])) {
        foreach ($_SESSION["cart_item"] as $item) {
            // Calculate total price for the order
            $item_total += ($item["price"] * $item["quantity"]);

            // Insert each item into the database
                        $SQL = "INSERT INTO users_orders (u_id, title, quantity, shoe_size, price, payment_method) VALUES ('".$_SESSION["user_id"]."', '".$item["title"]."', '".$item["quantity"]."', '".$item["size"]."', '".$item["price"]."', 'Online(RazorPay)')";
            mysqli_query($db, $SQL);
        }
        
        // Clear the cart after inserting items into the database
        unset($_SESSION["cart_item"]);

        // Redirect to the thank you page
        $success = "Thank you. Your order has been placed!";
        header("location:your_orders.php");
        exit(); // Make sure to exit after redirection
    } else {
        // If the cart is empty, redirect back to the shopping page
        header("location:index.php");
        exit(); // Make sure to exit after redirection
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You</title>
</head>
<body>
    <!-- Display success message if needed -->
    <?php if(isset($success)): ?>
        <p><?php echo $success; ?></p>
    <?php endif; ?>
</body>
</html>
