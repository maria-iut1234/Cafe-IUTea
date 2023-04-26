<?php
session_start();
require 'dbcon.php';

if(isset($_POST['delete_emp']))
{
    $emp_id = mysqli_real_escape_string($con, $_POST['delete_emp']);

    $query = "DELETE FROM employee WHERE e_id='$emp_id' ";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $_SESSION['message'] = "Employee Deleted Successfully";
        header("Location: index.php");
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "Employee Not Deleted";
        header("Location: index.php");
        exit(0);
    }
}

if(isset($_POST['update_emp']))
{
    $emp_id = mysqli_real_escape_string($con, $_POST['emp_id']);

    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $dob = mysqli_real_escape_string($con, $_POST['dob']);  
    $dob = date("Y-m-d",strtotime($dob));
    $address = mysqli_real_escape_string($con, $_POST['address']);

    $query = "UPDATE employee SET e_name='$name', e_email='$email', e_dob='$dob', e_address='$address' WHERE e_id='$emp_id' ";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $_SESSION['message'] = "Employee Updated Successfully";
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

    $password = "1234";

    $query = "INSERT INTO employee (e_id, e_name, e_password, e_pfp, e_dob, e_address, e_email) VALUES (default, '$name', '$password', default, '$dob', '$address', '$email')";

    $query_run = mysqli_query($con, $query);
    if($query_run)
    {
        $_SESSION['message'] = "Employee Created Successfully";
        header("Location: emp-create.php");
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "Employee Not Created";
        header("Location: emp-create.php");
        exit(0);
    }
}
