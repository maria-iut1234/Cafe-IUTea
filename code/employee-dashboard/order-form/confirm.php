<?php
session_start();
require 'dbcon.php';

$order_info = $_SESSION['order-info'];
$total = $order_info['total'];
date_default_timezone_set('Asia/Dhaka');
$date = date("Y-m-d");
echo $date;
$c_name = $order_info['c_name'];
$c_number = $order_info['c_contact'];


$query = "INSERT INTO orders (order_date, c_name, c_number, total) 
VALUES ('$date', '$c_name', '$c_number', '$total')";

if (mysqli_query($con, $query)) {
    ;
} else {
    echo "Error: " . mysqli_error($con);
}

header("Location: confirmed-order.php");
?>



