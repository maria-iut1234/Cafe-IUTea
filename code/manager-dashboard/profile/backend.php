<?php
session_start();
require 'dbcon.php';
require "mailer.php";
$messi = '';

if(isset($_SESSION['type']) && $_SESSION['type']=="manager")
    $messi = $_SESSION['id'];
else{
    header("location: ../../login/index.php");
}

if(isset($_POST['chng_pass'])){
    $m_id=$_POST['id'];
    $password = $_POST["pass"];
    $confirmPassword = $_POST["con_pass"];

    if ($password != $confirmPassword) {
        $_SESSION['message']="The Passwords Do Not Match.";
        header("location: ../profile/index.php");
        exit();
    } else if (strlen($password) < 8) {
        $_SESSION['message']="The Password must be atleast 8 characters.";
        header("location: ../profile/index.php");
        exit();
    } else if (ctype_upper($password) || ctype_lower($password)) {
        $_SESSION['message']="The Password must have a mixture of uppercase and lowercase letters.";
        header("location: ../profile/index.php");
        exit();
    }
    $hashedPass= password_hash($password,PASSWORD_DEFAULT);
    $sql="UPDATE manager SET m_password = '$hashedPass' WHERE m_id = '$m_id'";
    $query = mysqli_query($con, $sql);
    $_SESSION['message']="Updated Password Successfully";
    header("location: ../profile/index.php");
    exit();

}

if(isset($_POST['update_man']))
{
    $m_id = mysqli_real_escape_string($con, $_POST['m_id']);
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $dob = mysqli_real_escape_string($con, $_POST['dob']);  
    $dob = date("Y-m-d",strtotime($dob));
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $query = "UPDATE manager SET m_name='$name', m_dob='$dob', m_address='$address' WHERE m_id='$m_id' ";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $_SESSION['message'] = "Profile Updated Successfully";
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
                        $imageUpdateQuery = mysqli_query($con, "UPDATE manager SET m_pfp = '$new_image_name' WHERE m_id = '$m_id'") or die("query failed");
                        $_SESSION['message'] .= " and image has been updated successfully.";
                    } else {
                        $_SESSION['message'] .= " and you cannot upload files of this type.";
                    }
                }
            } else {
            }
        }
        header("Location: index.php");
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "Profile Not Updated";
        header("Location: index.php");
        exit(0);
    }

}
