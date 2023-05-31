<?php
session_start();
require 'dbcon.php';
$messi = '';

if(isset($_SESSION['type']) && $_SESSION['type']=="manager")
    $messi = $_SESSION['id'];
else{
    header("location: ../../login/index.php");
}
if(!isset($_POST['_id'])){
    header("location: index.php");
}
$in_id = mysqli_real_escape_string($con, $_POST['_id']);
$sql = "UPDATE inventories SET in_amount = 0 WHERE in_id = $in_id";
$query_run = mysqli_query($con, $sql);

$sql1= "SELECT * FROM inventories WHERE in_id = $in_id";
$query1 = mysqli_query($con,$sql1);
$res1 = mysqli_fetch_array($query1);
$in_name = $res1['in_name'];
$sql2 = "DELETE FROM notifications WHERE n_desc = '$in_name'";
$query_run2 = mysqli_query($con, $sql2);

$sql = "DELETE FROM inventories WHERE in_id = $in_id";
$query_run = mysqli_query($con, $sql);



$_SESSION['message']="Item Deleted Successfully";
header('location: index.php');

?>