<?php
session_start();
require 'dbcon.php';
$messi = '';

if (isset($_SESSION['type']) && $_SESSION['type'] == "manager")
    $messi = $_SESSION['id'];
else {
    header("location: ../../login/index.php");
}

if (isset($_POST['add_menu'])) {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $price = mysqli_real_escape_string($con, $_POST['price']);
    $sql = "SELECT * FROM menu WHERE menu_name = '$name'";
    $query_run = mysqli_query($con, $sql);
    if (mysqli_num_rows($query_run) > 0) {
        $_SESSION['message'] = "The Item Already Exists YOU DUMBASS!!";
        header('location: index.php');
    } else {
        $query = "INSERT INTO `menu`(`menu_id`, `menu_name`, `menu_price`) VALUES ('default','$name','$price')";
        $query_run = mysqli_query($con, $query);

        if ($query_run) {
            $_SESSION['message'] = "Menu Added Successfully";
            if (isset($_FILES['add_image'])) {
                $image = $_FILES['add_image']['name'];
                $imageSize = $_FILES['add_image']['size'];
                $imageTempName = $_FILES['add_image']['tmp_name'];
                $imageError = $_FILES['add_image']['error'];
                $default = "default_pfp.png";
                if ($imageError === 0) {
                    if ($imageSize > 1000000) {
                        $_SESSION['message'] .= " and sorry, the file is too large. Default image has been added";
                        $imageUpdateQuery = mysqli_query($con, "UPDATE menu SET menu_pfp = '$default' WHERE menu_name = '$name'") or die("query failed");
                    } else {
                        $image_ex = pathinfo($image, PATHINFO_EXTENSION);
                        $image_ex_lc = strtolower($image_ex);
                        $allowed_exs = array("jpg", "jpeg", "png");
                        if (in_array($image_ex_lc, $allowed_exs)) {
                            $new_image_name = uniqid("IMG-", true) . '.' . $image_ex_lc;
                            $imageFolder = '../../uploads/' . $new_image_name;
                            move_uploaded_file($imageTempName, $imageFolder);
                            $imageUpdateQuery = mysqli_query($con, "UPDATE menu SET menu_pfp = '$new_image_name' WHERE menu_name = '$name'") or die("query failed");
                            $_SESSION['message'] .= " and image has been updated successfully.";
                        } else {
                            $_SESSION['message'] .= " and you cannot upload files of this type. Default image has been added";
                            $imageUpdateQuery = mysqli_query($con, "UPDATE menu SET menu_pfp = '$default' WHERE menu_name = '$name'") or die("query failed");
                        }
                    }
                } else {
                    $_SESSION['message'] .= " and Default image has been added";
                    $imageUpdateQuery = mysqli_query($con, "UPDATE menu SET menu_pfp = '$default' WHERE menu_name = '$name'") or die("query failed");
                }
            } else {
                $_SESSION['message'] .= " an unknown error occured.";
            }
            header("Location: index.php");
            exit(0);
        } else {
            $_SESSION['message'] = "Menu was Not Added, there was an error";
            header("Location: index.php");
            exit(0);
        }
    }
}

if (isset($_POST['update_menu'])) {
    $menu_id = mysqli_real_escape_string($con, $_POST['menu_id']);
    $name = mysqli_real_escape_string($con, $_POST['menu_name']);
    $price = mysqli_real_escape_string($con, $_POST['menu_price']);

    $query = "UPDATE menu SET menu_name='$name', menu_price='$price' WHERE menu_id='$menu_id' ";
    $query_run = mysqli_query($con, $query);

    if ($query_run) {
        $_SESSION['message'] = "Menu Updated Successfully";
        if (isset($_FILES['update_image'])) {
            $image = $_FILES['update_image']['name'];
            $imageSize = $_FILES['update_image']['size'];
            $imageTempName = $_FILES['update_image']['tmp_name'];
            $imageError = $_FILES['update_image']['error'];

            if ($imageError === 0) {
                if ($imageSize > 1000000) {
                    $_SESSION['message'] .= " and sorry, the file is too large.";
                } else {
                    $image_ex = pathinfo($image, PATHINFO_EXTENSION);
                    $image_ex_lc = strtolower($image_ex);
                    $allowed_exs = array("jpg", "jpeg", "png");
                    if (in_array($image_ex_lc, $allowed_exs)) {
                        $new_image_name = uniqid("IMG-", true) . '.' . $image_ex_lc;
                        $imageFolder = '../../uploads/' . $new_image_name;
                        move_uploaded_file($imageTempName, $imageFolder);
                        $imageUpdateQuery = mysqli_query($con, "UPDATE menu SET menu_pfp = '$new_image_name' WHERE menu_id = '$menu_id'") or die("query failed");
                        $_SESSION['message'] .= " and image has been updated successfully.";
                    } else {
                        $_SESSION['message'] .= " and you cannot upload files of this type.";
                    }
                }
            } else {
                $_SESSION['message'] .= " an unknown error occured.";
            }
        }
        header("Location: index.php");
        exit(0);
    } else {
        $_SESSION['message'] = "Menu was Not Updated";
        header("Location: index.php");
        exit(0);
    }
}

if (isset($_POST['add_ing'])) {
    $menu_id = mysqli_real_escape_string($con, $_POST['menu_id']);
    $in_name = mysqli_real_escape_string($con, $_POST['in_name']);
    if($in_name==="Search Ingredient Name" || $in_name==="")
    {
        $_SESSION['message']="Choose an ingredient you idiot.";
        header('location: menu-add-ingredients.php?menu_id='.$menu_id);
    }
    $sql = "SELECT * FROM inventories WHERE in_name = '$in_name'";
    $query_run = mysqli_query($con, $sql);
    $inv = mysqli_fetch_array($query_run);
    $in_id = $inv['in_id'];
  
    $in_amount = mysqli_real_escape_string($con, $_POST['in_amount']);
    $query = "SELECT * FROM ingredients WHERE menu_id = '$menu_id' AND in_id ='$in_id'";
    $query_run = mysqli_query($con, $query);
    if (mysqli_num_rows($query_run) > 0) {
        $res = mysqli_fetch_array($query_run);
        if ($res['ing_amount'] === $in_amount){
            $_SESSION['message'] = "The Ingredient already Exists in that Quantity.";
            header('location: menu-add-ingredients.php?menu_id='.$menu_id);
        }
        else {
            $query = "UPDATE ingredients SET ing_amount='$in_amount' WHERE menu_id='$menu_id' AND in_id = '$in_id'";
            $query_run = mysqli_query($con, $query);
            $query = "SELECT * FROM ingredients WHERE menu_id='$menu_id' AND in_id = '$in_id'";
            $query_run = mysqli_query($con, $query);
            $r = mysqli_fetch_array($query_run);
            if($r['ing_amount']==0)
            {
                $query = "DELETE from ingredients WHERE menu_id = '$menu_id' AND in_id = '$in_id'";
                $query_run = mysqli_query($con, $query);
                $_SESSION['message'] = "The Ingredient has been deleted since its value is 0.";
            }
            else{
                $_SESSION['message'] = "The Ingredient Quantity has been updated.";
            }
            header('location: menu-add-ingredients.php?menu_id='.$menu_id);
        }
    } else {
        $query = "INSERT INTO `ingredients`(`menu_id`, `in_id`, `ing_amount`) VALUES ('$menu_id','$in_id','$in_amount')";
        $query_run = mysqli_query($con, $query);
        $_SESSION['message'] = "The New Ingredient has been added to the List.";
        header('location: menu-add-ingredients.php?menu_id='.$menu_id);
    }
}

if (isset($_POST['delete_menu'])) {
    $menu_id = $_POST['menu_id'];
    $query = "DELETE from ingredients WHERE menu_id = '$menu_id'";
    $query_run = mysqli_query($con, $query);
    $query = "DELETE from menu WHERE menu_id = '$menu_id'";
    $query_run = mysqli_query($con, $query);
    $_SESSION['message'] = "The Menu Item has been Deleted Successfully.";
    header('location: index.php');
}
