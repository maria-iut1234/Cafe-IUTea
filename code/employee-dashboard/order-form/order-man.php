<?php
session_start();
require 'dbcon.php';

$messi = '';

// if(isset($_SESSION['type']) && $_SESSION['type']=="employee")
//     $messi = $_SESSION['id'];
// else{
//     header("location: ../../login/index.php");
// }

?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- <link href="bootstrap.css" rel="stylesheet"> -->

    <link href="sidebar.css" rel="stylesheet">
    <link href="form.css" rel="stylesheet">
    <link href="order-man.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

    <link rel="shortcut icon" href="images/logo.ico">

    <title>Order Management</title>

</head>

<body>

    <header>
        <h1>Welcome Employee</h1>
    </header>

    <input type="checkbox" id="active" />
    <label for="active" class="menu-btn"><i class="fas fa-bars"></i></label>
    <div class="wrapper">
        <ul>
            <li><img class="iutea-icon" src="images/logo.png"></li>
            <li><a href="index.php">Order Management</a></li>
            <li><a href="#">Settings</a></li>
            <li><a href="<?php echo $messi ? '../../login/logout.php' : '../../login/index.php'; ?>"><?php echo $messi ? 'Log Out' : 'Log In'; ?></a></li>
        </ul>
    </div>

    <!-- <div class="other-btn">
        <a href="#" class="btn btn-add float-end">Add Employee</a>
    </div> -->

    <div class="container mt-4">
        <div class="title">
            <h1>Order Management</h1>
        </div>
    </div>

    <div class="order-container">
        <form method="POST" class="order-form">
            <div class="form__input-group customer-name">
                <input type="text" class="form__input first-name" autofocus placeholder="Enter First Name">
                <input type="text" class="form__input last-name" autofocus placeholder="Enter Last Name">
            </div>
            <div class="form__input-group">
                <input type="text" class="form__input" autofocus placeholder="Enter Customer Contact">
            </div>
            <div class="form__input-group">
                <select class="form__input" id="type" name="type">
                    <option value="" disabled selected>Add Menu Item</option>
                    <option>Employee</option>
                    <option>Manager</option>
                </select>
            </div>
            <button class="form__button" type="submit">Place Order</button>
        </form>

    </div>

    <footer>
        <p><small>&copy; Copyright 2023 IUTea. All Rights Reserved</small> </p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</body>

</html>