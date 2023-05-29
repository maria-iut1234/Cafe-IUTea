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

    <title>Order Confirmation</title>

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

    <!-- <div class="other-btn">
        <a href="#" class="btn btn-add float-end">Add Employee</a>
    </div> -->

    <div class="container mt-4">
        <div class="title">
            <h1>Order Confirmation</h1>
        </div>
    </div>

    <div class="lottie-container">
        <lottie-player src="images/confirm-order.json" background="#F2F7F2" speed="1" style="width: 500px; height: 500px;" autoplay loop></lottie-player>
    </div>
    <div class="order-container order-confirm">
        <form method="POST" action="confirm.php" class="order-form order-confirm">
            <div class="order-confirm-form">
                <h2 class="menu-items-h2">Menu Items:</h2>
                <div class="menu-items-table">
                    <table class="tg">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Size</th>
                                <th>Add-Ons</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            for ($i = 0; $i < $counter; $i++) {
                                $menuArrayName = 'menu' . $i;

                                if (1) {
                                    $menuItem = $_SESSION[$menuArrayName];
                                    // echo $$menuArrayName['name'];
                            ?>
                                    <tr>
                                        <td><?php echo $menuItem['name']; ?></td>
                                        <td><?php echo $menuItem['size']; ?></td>
                                        <td><?php echo $menuItem['adds']; ?></td>
                                        <td><?php echo $menuItem['quantity']; ?></td>
                                        <td><?php echo $menuItem['subtotal']; ?></td>
                                    </tr>
                            <?php
                                }
                            }
                            ?>
                        </tbody>

                    </table>

                </div>

                <?php $order_info = $_SESSION['order-info'] ?>

                <div class="info-table">
                    <table>
                        <thead>
                            <tr>
                                <th>Total Amount: </th>
                                <th>Tk.<?php echo $order_info['total']; ?></th>
                            </tr>
                            <tr>
                                <th>Customer Name: </th>
                                <th><?php echo $order_info['c_name']; ?></th>
                            </tr>
                            <tr>
                                <th>Employee Name: </th>
                                <th><?php echo $order_info['e_name']; ?></th>
                            </tr>
                            <tr>
                                <th id="date"></th>
                            </tr>
                        </thead>

                    </table>

                </div>



            </div>


            <div class="order-con-btn">
                <button class="form__button cancel" type="button" onclick="goToOrderMan()">Cancel</button>
                <button class="form__button confirm-order" name="confirm-order" type="submit">Confirm Order</button>
            </div>
        </form>

    </div>

    <footer>
        <p><small>&copy; Copyright 2023 IUTea. All Rights Reserved</small> </p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    <script>
        // Get today's date
        var today = new Date();

        // Extract date components
        var day = today.getDate();
        var month = today.getMonth() + 1; // Month is zero-based, so add 1
        var year = today.getFullYear();

        // Format the date as desired (e.g., "MM/DD/YYYY")
        var formattedDate = month + '/' + day + '/' + year;

        formattedDate = 'Date: ' + formattedDate;

        // Display the date in the HTML element with id "date"
        document.getElementById("date").textContent = formattedDate;

        function goToOrderMan() {
            window.location.href = "order-man.php";
        }
    </script>

</body>

</html>