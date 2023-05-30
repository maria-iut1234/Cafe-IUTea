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
    $price = mysqli_real_escape_string($con, $_POST['in_price']);

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
        $res = mysqli_fetch_array($result);
    }
    if ((mysqli_num_rows($result) > 0)) {
        if($res['in_price']==$price){
        $error = "This Item already exists in the inventory!!";
        }
        else{
            $sql = "UPDATE inventories SET in_price = '$price' WHERE in_name = '$name'";
            $query= mysqli_query($con,$sql);
            $_SESSION['message'] = "The price of ".$name." has been updated!";
            header("Location: index.php");
            exit(0);
        }
    }


    if (empty($error)) {
        $stmt = $con->prepare("INSERT INTO inventories (in_id, in_name, in_amount,in_price) VALUES (default,?,0,?)");
        $stmt->bind_param("ss", $name,$price);
        $stmt->execute();
        $stmt->close();
        $con->close();
        $_SESSION['message'] = "$name has been Added Successfully";
        header("Location: index.php");
        exit(0);
    } else {
        if ($error) {
            $_SESSION['message'] = "Ayy Caramba. ".$name." could not be added due to some error!";
            header("Location: index.php");
        }
        $_SESSION['message'] = "ekhane to ashar kotha na bhai ken ashche Allah janen.";
        header("location: index.php");
        exit(0);
    }
}
