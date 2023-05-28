<?php
session_start();
require 'dbcon.php';
$messi = '';

if (isset($_SESSION['type']) && $_SESSION['type'] == "manager")
    $messi = $_SESSION['id'];
else {
    header("location: ../../login/index.php");
}

if (isset($_POST['additem'])) {
    $name = mysqli_real_escape_string($con, $_POST['in_name']);

    $error = '';


    $sql = "SELECT * FROM inventories WHERE in_name =?;";
    $stmt = mysqli_stmt_init($con);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "There was an error preparing while checking unique email";
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "s", $name);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
    }
    if (mysqli_num_rows($result) > 0) {
        $error = "This Item already exists in the inventory!!";
    }


    if (empty($error)) {
        $stmt = $con->prepare("INSERT INTO inventories (in_id, in_name, in_amount) VALUES (default,?,0)");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $stmt->close();
        $con->close();
        $_SESSION['message'] = "Item Added Successfully";
        header("Location: index.php");
        exit(0);
    } else {
        if ($error) {
            $_SESSION['message'] = "Ayy Caramba. The item could not be added due to some error!";
            header("Location: index.php");
        }
        $_SESSION['message'] = "ekhane to ashar kotha na bhai ken ashche Allah janen.";
        header("location: index.php");
        exit(0);
    }
}
