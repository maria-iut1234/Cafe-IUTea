<?php
session_start();
require 'dbcon.php';
require 'order-han.php';

$order_info = $_SESSION['order-info'];
$total_price = $order_info['total_price'];
$total_cost = $order_info['total_cost'];
date_default_timezone_set('Asia/Dhaka');
$date = date("Y-m-d");
echo $date;
$c_name = $order_info['c_name'];
$c_number = $order_info['c_contact'];


$query = "INSERT INTO orders (order_date, c_name, c_number, total_price, total_cost) 
VALUES ('$date', '$c_name', '$c_number', '$total_price', '$total_cost')";

if (mysqli_query($con, $query)) {
    ;
} else {
    echo "Error: " . mysqli_error($con);
}

//fetching inventory details
$query_inv = "SELECT * FROM inventories_view";
$query_inv_run = mysqli_query($con, $query_inv);

$inventory = array();

while ($inv = mysqli_fetch_assoc($query_inv_run)) {
    $inventory[$inv['in_id']] = $inv;
}

// echo "Order is possible. <br>";

$ingredient_count = $_SESSION['ingredient-count'];

//updating inventory
for ($i = 0; $i < count($ingredient_count); $i++) {
    if ($ingredient_count[$i] > 0) {

        // echo "Ing ID " . $i . " needed " . $ingredient_count[$i] . "<br>";

        if (isset($inventory[$i])) {

            $inv = $inventory[$i];

            // echo "Ing ID " . $i . ", Inv ID " . $inv['in_id'] . "<br>";

            $new_inv_amount = $inv['in_amount'] - $ingredient_count[$i];

            $update = "UPDATE inventories SET in_amount = '$new_inv_amount' WHERE in_id = '$i'";
            $update_run = mysqli_query($con, $update);

            if ($update_run) {
                // echo "Successful" . " " . $new_inv_amount . " " . $i . "<br>";
            } else {
                echo "Error executing the query: " . mysqli_error($con);
            }
        }
    }
}

$ingredient_count = [];
$ingredients = [];
$menu_items_list = [];
$not_possible_items = [];

header("Location: confirmed-order.php");
