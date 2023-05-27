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
$sql = "DELETE FROM inventories WHERE in_id = $in_id";
$query_run = mysqli_query($con, $sql);
$_SESSION['message']="Item Deleted Successfully";
header('location: index.php');

?>