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

function rand_Pass($upper = 1, $lower = 5, $numeric = 3, $other = 2) { 
    
    $pass_order = Array(); 
    $passWord = ''; 

    //Create contents of the password 
    for ($i = 0; $i < $upper; $i++) { 
        $pass_order[] = chr(rand(65, 90)); 
    } 
    for ($i = 0; $i < $lower; $i++) { 
        $pass_order[] = chr(rand(97, 122)); 
    } 
    for ($i = 0; $i < $numeric; $i++) { 
        $pass_order[] = chr(rand(48, 57)); 
    } 
    for ($i = 0; $i < $other; $i++) { 
        $pass_order[] = chr(rand(33, 47)); 
    } 

    //using shuffle() to shuffle the order
    shuffle($pass_order); 

    //Final password string 
    foreach ($pass_order as $char) { 
        $passWord .= $char; 
    } 
    return $passWord; 
} 

if(isset($_POST['update_emp']))
{
    $emp_id = mysqli_real_escape_string($con, $_POST['emp_id']);
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $dob = mysqli_real_escape_string($con, $_POST['dob']);  
    $dob = date("Y-m-d",strtotime($dob));
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $query = "UPDATE employee SET e_name='$name', e_dob='$dob', e_address='$address' WHERE e_id='$emp_id' ";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $_SESSION['message'] = "Employee Updated Successfully";
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
                        $imageUpdateQuery = mysqli_query($con, "UPDATE employee SET e_pfp = '$new_image_name' WHERE e_id = '$emp_id'") or die("query failed");
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
        $_SESSION['message'] = "Employee Not Updated";
        header("Location: index.php");
        exit(0);
    }

}


if(isset($_POST['save_emp']))
{
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $dob = mysqli_real_escape_string($con, $_POST['dob']);  
    $dob = date("Y-m-d",strtotime($dob));
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $password = rand_Pass();
    $emailError=$emailError1='';


    $sql = "SELECT * FROM employee WHERE e_email =?;";
    $stmt = mysqli_stmt_init($con);
    if(!mysqli_stmt_prepare($stmt,$sql)){
        echo "There was an error preparing while checking unique email";
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt,"s",$email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $emailError = "Invalid Email";
    }
    if(mysqli_num_rows($result) > 0){
        $emailError1 = "An account already exists under this email in our database";
    }


    if(empty($emailError) && empty($emailError1)){
    // $query = "INSERT INTO employee (e_id, e_name, e_password, e_pfp, e_dob, e_address, e_email) VALUES (default, '$name', '$password', default, '$dob', '$address', '$email')";
    // $query_run = mysqli_query($con, $query);
    $stmt = $con ->prepare("INSERT INTO employee (e_id, e_name, e_password, e_pfp, e_dob, e_address, e_email) VALUES (default,?,?,default,?,?,?)");
    $stmt -> bind_param("sssss",$name,password_hash($password,PASSWORD_DEFAULT),$dob,$address,$email);
    $stmt -> execute();
    $stmt -> close();
    // $con -> close();
    $to = $email;
    $url = "http://localhost:3000/login/index.php";
    $subject = 'Registration as an Employee of Coffee Cafe is Complete';
    $message = '<p>Welcome to Coffee Cafe. Your registration as an employee is now complete. Your Login Credentials are:</p>';
    $message .= '<p>Email: '.$email.'</p>';
    $message .= '<p>Password: '.$password.'</p>';
    $message .= '<p>We Look forward to working with you!</br>Stay Energized with Coffee Cafe. </br>You can get started at the following Link: </br>';
    $message .='<a href="'.$url.'">'.$url.'</a?></p>';
    send_mail($to,$subject,$message);
    $_SESSION['message'] = "Employee Created Successfully";
    if (isset($_FILES['add_image'])) {
        $image = $_FILES['add_image']['name'];
        $imageSize = $_FILES['add_image']['size'];
        $imageTempName = $_FILES['add_image']['tmp_name'];
        $imageError = $_FILES['add_image']['error'];
        $default = "avatar-default.png";
        if ($imageError === 0) {
            if ($imageSize > 1000000) {
                $_SESSION['message'] .= " and sorry, the file is too large. Default image has been added";
                $imageUpdateQuery = mysqli_query($con, "UPDATE employee SET e_pfp = '$default' WHERE e_email = '$email'") or die("query failed");
            } else {
                $image_ex = pathinfo($image, PATHINFO_EXTENSION);
                $image_ex_lc = strtolower($image_ex);
                $allowed_exs = array("jpg", "jpeg", "png");
                if (in_array($image_ex_lc, $allowed_exs)) {
                    $new_image_name = uniqid("IMG-", true) . '.' . $image_ex_lc;
                    $imageFolder = '../../uploads/' . $new_image_name;
                    move_uploaded_file($imageTempName, $imageFolder);
                    $imageUpdateQuery = mysqli_query($con, "UPDATE employee SET e_pfp = '$new_image_name' WHERE e_email = '$email'") or die("query failed");
                    $_SESSION['message'] .= " and image has been updated successfully.";
                } else {
                    $_SESSION['message'] .= " and you cannot upload files of this type. Default image has been added";
                    $imageUpdateQuery = mysqli_query($con, "UPDATE employee SET e_pfp = '$default' WHERE e_email = '$email'") or die("query failed");
                }
            }
        } else {
            $_SESSION['message'] .= " and Default image has been added";
            $imageUpdateQuery = mysqli_query($con, "UPDATE employee SET e_pfp = '$default' WHERE e_email = '$email'") or die("query failed");
        }
    } else {
    }
        header("Location: emp-create.php");
        exit(0);
    }
    else
    {
        if($emailError)
        {
            $_SESSION['message'] = "The entered email is Invalid!";
            header("Location: emp-create.php");
        }
        if($emailError1)
        {
            $_SESSION['message'] = "A user under this email already exists!";
            header("Location: emp-create.php");
        }
        exit(0);
    }
}
