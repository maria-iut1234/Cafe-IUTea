<?php
session_start();
require 'dbcon.php';
$messi = '';

if (isset($_SESSION['type']) && $_SESSION['type'] == "manager")
    $messi = $_SESSION['id'];
else {
    header("location: ../../login/index.php");
}

if (isset($_POST['confirmremove'])) {
    if (!isset($_POST['in_name'])) {
        header("location: notif.php");
        exit(0);
    }
    $in_name = mysqli_real_escape_string($con, $_POST['in_name']);
    $sql = "DELETE FROM notifications WHERE n_desc = '$in_name'";
    $query=mysqli_query($con,$sql);
    $_SESSION['message'] = "Successfully removed the notification";
    header("location: notif.php?name=".$in_name);
}
