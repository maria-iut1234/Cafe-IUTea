<?php
session_start();
require 'dbcon.php';

$messi = '';

if(isset($_SESSION['type']) && $_SESSION['type']=="employee")
{
    $messi = $_SESSION['id'];
    $sub_str = substr($messi, -6, -3);   
    
} else{
    header("location: ../../login/index.php");
}

?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="src/sidebar.css" rel="stylesheet">
    <link href="src/form.css" rel="stylesheet">
    <link href="src/order-man.css" rel="stylesheet">
    <link href="src/basic.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

    <link rel="shortcut icon" href="images/logo.ico">

    <title>Order Confirmation</title>

</head>

<body>

<header>
        <h1><?=$sub_str?$sub_str:"Employee"?></h1>
    </header>

    <input type="checkbox" id="active" />
    <label for="active" class="menu-btn"><i class="fas fa-bars"></i></label>
    <div class="wrapper">
        <ul>
            <li><img class="iutea-icon" src="images/logo.png"></li>
            <li><a href="../order-form/order-man.php">Order Management</a></li>
            <li><a href="../profile/index.php">Settings</a></li>
            <li><a href="<?php echo $messi ? '../../login/logout.php' : '../../login/index.php'; ?>"><?php echo $messi ? 'Log Out' : 'Log In'; ?></a></li>
        </ul>
    </div>

    <div class="container mt-4">
        <div class="title">
            <h1>Order Confirmed!</h1>
        </div>

    </div>

    <div class="lottie-confirmed">
        <lottie-player src="images/confirmed.json" background="#F2F7F2" speed="1" style="width: 400px; height: 400px;" autoplay></lottie-player>
    </div>

    <div class="back-btn">
        <button class="form__button cancel" type="button" onclick="goToOrderMan()">Back</button>
    </div>
    
    
    <footer>
        <p><small>&copy; Copyright 2023 IUTea. All Rights Reserved</small> </p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    <script src="order-con.js"></script>

</body>

</html>