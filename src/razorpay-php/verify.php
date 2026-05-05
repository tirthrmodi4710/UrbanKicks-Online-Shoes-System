
<?php

require('config.php');

session_start();

require('razorpay-php/Razorpay.php');
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

$success = true;

$error = "Payment Failed";

if (empty($_POST['razorpay_payment_id']) === false)
{
    $api = new Api($keyId, $keySecret);

    try
    {
        // Please note that the razorpay order ID must
        // come from a trusted source (session here, but
        // could be database or something else)
        $attributes = array(
            'razorpay_order_id' => $_SESSION['razorpay_order_id'],
            'razorpay_payment_id' => $_POST['razorpay_payment_id'],
            'razorpay_signature' => $_POST['razorpay_signature'],
            // 'name'=>$_SESSION['name'],
            // 'email'=>$_SESSION['email']
            
        
        );

        $api->utility->verifyPaymentSignature($attributes);
    }
    catch(SignatureVerificationError $e)
    {
        $success = false;
        $error = 'Razorpay Error : ' . $e->getMessage();
    }
}

if ($success === true)
{
    $html = "<p>Your payment was successful</p>
             <p>Payment ID: {$_POST['razorpay_payment_id']}</p>";

             
}
else
{
    $html = "<p>Your payment failed</p>
             <p>{$error}</p>";
}


 echo $order=$_SESSION['razorpay_order_id'];
echo $payment= $_POST['razorpay_payment_id'];
// echo $name=$_SESSION['name'];
// echo $email=$_SESSION['email'];
//  echo $amount= $_SESSION['price'];
// echo $evn_name=$_SESSION['evn_name'];


$conn=mysqli_connect("localhost" ,"root","","home_services");



$id=$_SESSION["user_id"];
//  $_SESSION["user_name"];



echo  $price=$_SESSION["price"];

echo  $sp_name=$_SESSION["sp_name"];

 $sql="SELECT * FROM users WHERE u_id='{$id}'";



  $Result=mysqli_query($conn,$sql);

 $row=mysqli_fetch_assoc($Result);

echo  $name= $row['f_name'];



//  $sql2="INSERT INTO payment (payment_id,Cust_name,SP_Name,Order_id,Price)VALUES ('$payment','$name','$sp_name','$order','$price')";

// $result=mysqli_query($conn,$sql2);

//  if($result){
//      echo "data insert sussessfullly ";
//      header("location:../your_orders.php");
//  }else{
//     echo " data not insert";
//  }




echo $html;
 header("location:../your_orders.php");
