<?php
session_start();
require 'dbcon.php';
$messi = '';

if(isset($_SESSION['type']) && $_SESSION['type']=="manager")
    $messi = $_SESSION['id'];
else{
    header("location: ../../login/index.php");
}


if(isset($_POST['update_menu']))
{
    $menu_id = mysqli_real_escape_string($con, $_POST['menu_id']);
    $name = mysqli_real_escape_string($con, $_POST['menu_name']);
    $price = mysqli_real_escape_string($con, $_POST['menu_price']);
    $query = "UPDATE menu SET menu_name='$name', menu_price='$price' WHERE menu_id='$menu_id' ";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $_SESSION['message'] = "Menu Updated Successfully";
        header("Location: index.php");
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "Menu was Not Updated";
        header("Location: index.php");
        exit(0);
    }

}