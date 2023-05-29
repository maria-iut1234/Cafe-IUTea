<?php
session_start();
require 'dbcon.php';
// require 'order-han.php';

$counter = isset($_SESSION['menu-item-counter']) ? $_SESSION['menu-item-counter'] : 0;

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

    <link href="src/sidebar.css" rel="stylesheet">
    <link href="src/form.css" rel="stylesheet">
    <link href="src/order-man.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

    <link rel="shortcut icon" href="images/logo.ico">

    <title>Order Error</title>

    <style>

    </style>

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

    <div class="container mt-4">
        <div class="title">
            <h1>Order Not Confirmed!</h1>
        </div>

    </div>

    <div class="lottie-error">

        <lottie-player class="error-sign" src="images/error-sign.json" background="#F2F7F2" speed="1" style="width: 200px; height: 200px;" autoplay></lottie-player>

        <lottie-player class="error-cup" src="images/error-order.json" background="#F2F7F2" speed="1" style="width: 500px; height: 400px;" autoplay loop></lottie-player>

    </div>

    <div class="error-message">
        <h3>The following menu items are not possible:</h3>
        <ol>
            <?php
            $menu_items = $_SESSION['menu_items'];

            for ($i = 0; $i < count($menu_items); $i++) {
            ?>
                <li><?php echo $menu_items[$i]; ?></li>
            <?php

            }
            ?>
        </ol>

        <h3>Because there is a lack of the following ingrediants:</h3>
        <ol>
            <?php
            $ingredients = $_SESSION['ingredients'];

            for ($i = 0; $i < count($ingredients); $i++) {
            ?>
                <li><?php echo $ingredients[$i]; ?></li>
            <?php

            }
            ?>
        </ol>
    </div>

    <footer>
        <p><small>&copy; Copyright 2023 IUTea. All Rights Reserved</small> </p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

</body>

</html>