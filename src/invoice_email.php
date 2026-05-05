<?php

require "vendor/autoload.php"; // Include PHPMailer autoload file
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$servername = "localhost";
$username = "root";
$password = "";
$database = "URBANKICKS";

try {
    // Create connection
    $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Check if the order ID is provided in the query string
    if(isset($_GET['order_id'])) {
        // Retrieve the order ID from the query string
        $order_id = $_GET['order_id'];

        // Query to fetch order details from the database
        $query_order = "SELECT o_id, title, quantity, price, date, status, shoe_size FROM users_orders WHERE o_id = ?";
        $stmt_order = $conn->prepare($query_order);
        $stmt_order->bind_param("i", $order_id);
        $stmt_order->execute();
        $result_order = $stmt_order->get_result();

        // Query to fetch customer details from the database
        $query_customer = "SELECT * FROM users WHERE u_id IN (SELECT u_id FROM users_orders WHERE o_id = ?)";
        $stmt_customer = $conn->prepare($query_customer);
        $stmt_customer->bind_param("i", $order_id);
        $stmt_customer->execute();
        $result_customer = $stmt_customer->get_result();

        // Construct HTML email content
        $html_content = '<html>
            <head>
                <title>Invoice</title>
            </head>
            <body>
                <h1>Invoice</h1>';
        
        // Display customer information
        if ($result_customer->num_rows > 0) {
            $customer_row = $result_customer->fetch_assoc();
            $html_content .= '<p>Customer Name: ' . $customer_row['f_name'] . ' ' . $customer_row['l_name'] . '</p>
                              <p>Email: ' . $customer_row['email'] . '</p>
                              <p>Phone: ' . $customer_row['phone'] . '</p>
                              <p>Address: ' . $customer_row['address'] . '</p>';
        }

        // Display order details
        if ($result_order->num_rows > 0) {
            $html_content .= '<table border="1">
                                <tr>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Price (₹)</th>
                                    <th>Total (₹)</th>
                                </tr>';
            while ($row = $result_order->fetch_assoc()) {
                $total_price = $row['quantity'] * $row['price'];
                $html_content .= '<tr>
                                    <td>' . $row['title'] . '</td>
                                    <td>' . $row['quantity'] . '</td>
                                    <td>₹ ' . $row['price'] . '</td>
                                    <td>₹ ' . $total_price . '</td>
                                </tr>';
            }
            $html_content .= '</table>';
        } else {
            $html_content .= '<p>No order details found.</p>';
        }

        // Additional notes or information
        $html_content .= '<p>Thank you for your order!</p>
            </body>
            </html>';

        // Close connection
        $conn->close();

        // Send HTML email
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = "smtp.gmail.com";
            $mail->Port = 587;
            $mail->SMTPSecure = "tls";
            $mail->SMTPAuth = true;
            $mail->Username = "kushvaishnav234@gmail.com";
            $mail->Password = "bixzptrcnjjfkfzq";
            $mail->setFrom("Kushvaishnav234@gmail.com", "UrbanKicks");
            $mail->addAddress($customer_row['email']);
            $mail->isHTML(true);
            $mail->Subject = "Invoice";
            $mail->Body = $html_content;

        if($mail->send()) {
            // Redirect to your_orders.php after successful email sending
            echo '<script>window.location.href = "your_orders.php"; </script>';
    exit;   
        } else {
            echo "Failed to send email: " . $mail->ErrorInfo;
        }
    } else {
        // If order ID is not provided, redirect back to the previous page or handle the error accordingly
        header('Location: previous_page.php');
        exit;
    }
} catch(Exception $e) {
    // Log the error
    error_log('Error: ' . $e->getMessage(), 3, "error.log");
    // Display a friendly error message to the user
    echo "An error occurred. Please try again later.";
}
?>

 