<?php

require('config.php');
require('razorpay-php/Razorpay.php');
session_start();

// Create the Razorpay Order
use Razorpay\Api\Api;

$api = new Api($keyId, $keySecret);

$id = $_SESSION["user_id"];
$cname = $_SESSION["username"];
$price = $_SESSION["price"];

$conn = mysqli_connect("localhost", "root", "", "URBANKICKS");

$orderData = [
    'receipt'         => 3456, // You can set the order receipt dynamically
    'amount'          => $price * 100, // Amount in paise
    'currency'        => 'INR',
    'payment_capture' => 1 // auto capture
];

$razorpayOrder = $api->order->create($orderData);

$razorpayOrderId = $razorpayOrder['id'];

$_SESSION['razorpay_order_id'] = $razorpayOrderId;

$displayAmount = $amount = $orderData['amount'];

// Check if the currency is not INR and make necessary adjustments
if ($displayCurrency !== 'INR') {
    $url = "https://api.fixer.io/latest?symbols=$displayCurrency&base=INR";
    $exchange = json_decode(file_get_contents($url), true);
    $displayAmount = $exchange['rates'][$displayCurrency] * $amount / 100;
}

$checkout = 'automatic';

// Check if 'checkout' parameter is set and valid
if (isset($_GET['checkout']) and in_array($_GET['checkout'], ['automatic', 'manual'], true)) {
    $checkout = $_GET['checkout'];
}

$data = [
    "key"               => $keyId,
    "amount"            => $amount,
    "name"              => "Home Services", // Set your business name here
    "description"       => "Home Related Services", // Set description
    "image"             => "https://s29.postimg.org/r6dj1g85z/daft_punk.jpg", // Your business logo image URL
    "prefill"           => [
        "name"              => $cname, // User's name
        "email"             => "chirag123@gmail.com", // User's email (you can set dynamically if available)
        "contact"           => "9999999999", // User's contact number (you can set dynamically if available)
    ],
    "notes"             => [
        "address"           => "Hello World", // Set user's address here if available
        "merchant_order_id" => "12312321", // Your internal order ID
    ],
    "theme"             => [
        "color"             => "#F37254" // Set theme color
    ],
    "order_id"          => $razorpayOrderId,
];

// Check if the currency is not INR and add display_currency and display_amount to data
if ($displayCurrency !== 'INR') {
    $data['display_currency']  = $displayCurrency;
    $data['display_amount']    = $displayAmount;
}

$json = json_encode($data);

require("checkout/{$checkout}.php");
