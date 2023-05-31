<?php
session_start();
require 'dbcon.php';
$messi = '';

if(isset($_SESSION['type']) && $_SESSION['type']=="manager")
    $messi = $_SESSION['id'];
else{
    header("location: ../../login/index.php");
}
if(isset($_POST['confirmrestock'])){
if(!isset($_POST['i_name'])){
    header("location: notif.php");
    exit(0);
}

$in_name = mysqli_real_escape_string($con, $_POST['i_name']);
$in_qty = mysqli_real_escape_string($con, $_POST['in_qty']);
$in_expiration = $_POST['expiration'];
date_default_timezone_set('Asia/Dhaka');
$in_order = date('Y-m-d');
$sql = "SELECT * FROM inventories WHERE in_name = '$in_name'";
$query_run = mysqli_query($con, $sql);
$inv = mysqli_fetch_array($query_run);
$in_id = $inv['in_id'];

if(strtotime($in_order)>strtotime($in_expiration)){
    $_SESSION['message']="You are buying expired stuff bRuH..";
    header("location: notif.php");
}
else{
    $curr_qty = intval($inv['in_amount'])+intval($in_qty); 
    $sql = "UPDATE inventories SET in_amount = $curr_qty WHERE in_id = '$in_id'";
    $query_run = mysqli_query($con, $sql);
    $sql = "INSERT INTO inventory_orders (in_id, o_amount, o_date, e_date) VALUES ('$in_id', $in_qty, CURDATE(), DATE('$in_expiration'))";
    $query = mysqli_query($con,$sql);

    $sql2 = "SELECT * FROM inventories WHERE in_id = $in_id";
    $query_run2 = mysqli_query($con, $sql2);
    $r = mysqli_fetch_array($query_run2);
    $in_name = $r['in_name'];


    $sql = "UPDATE notifications SET n_status = 1 WHERE n_desc = '$in_name'";
    $query = mysqli_query($con,$sql);
    $con->close();
    $_SESSION['message']="Successfully Restocked on ".$inv['in_name'];
    header("location: notif.php");
}
}
