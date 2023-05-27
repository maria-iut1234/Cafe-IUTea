<?php
session_start();
require 'dbcon.php';
$messi = '';

if(isset($_SESSION['type']) && $_SESSION['type']=="manager")
    $messi = $_SESSION['id'];
else{
    header("location: ../../login/index.php");
}
if(!isset($_POST['in_id'])){
    header("location: index.php");
}


$in_id = mysqli_real_escape_string($con, $_POST['in_id']);
$in_qty = mysqli_real_escape_string($con, $_POST['in_qty']);
$in_expiration = $_POST['expiration'];
date_default_timezone_set('Asia/Dhaka');
$in_order = date('Y-m-d');
$sql = "SELECT * FROM inventories WHERE in_id = $in_id";
$query_run = mysqli_query($con, $sql);
if (mysqli_num_rows($query_run) > 0) {
    $inv = mysqli_fetch_array($query_run);
}
if(strtotime($in_order)>strtotime($in_expiration)){
    $_SESSION['message']="You are buying expired stuff bRuH..";
    header("location: index.php");
}
else{
    $curr_qty = intval($inv['in_amount'])+intval($in_qty); 
    $sql = "UPDATE inventories SET in_amount = $curr_qty WHERE in_id = $in_id";
    $query_run = mysqli_query($con, $sql);
    $stmt = $con ->prepare("INSERT INTO inventory_orders (in_ord_id, in_id, o_amount, o_date, e_date) VALUES (default,?,?,?,?)");
    $stmt -> bind_param("ssss",$in_id,$in_qty,$in_order,$in_expiration);
    $stmt -> execute();
    $stmt -> close();
    $con -> close();
    $_SESSION['message']="Successfully Restocked on ".$inv['in_name'];
    header("location: index.php");
}


?>
