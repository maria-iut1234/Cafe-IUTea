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

    <img src="images/confirm-order.png" alt="Description of the image">

    <div class="order-container order-confirm">
        <form method="POST" class="order-form order-confirm">
            <div class="order-confirm-form">
                <h2 class="menu-items-h2">Menu Items:</h2>
                <div class="menu-items-table">
                    <table class="tg">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Size (Prize)</th>
                                <th>Add-Ons (Prize)</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Cappuccino</td>
                                <td>Small (250)</td>
                                <td>Hazelnut (50)</td>
                                <td>2</td>
                                <td>Tk.600</td>
                            </tr>
                            <tr>
                                <td>Cappuccino</td>
                                <td>Small (250)</td>
                                <td>Hazelnut (50)</td>
                                <td>2</td>
                                <td>Tk.600</td>
                            </tr>
                        </tbody>

                    </table>

                </div>

                <div class="info-table">
                    <table>
                        <thead>
                            <tr>
                                <th>Total Amount: </th>
                                <th>Tk.600</th>
                            </tr>
                            <tr>
                                <th>Customer Name: </th>
                                <th>Shanta Maria</th>
                            </tr>
                            <tr>
                                <th>Employee Name: </th>
                                <th>Nazz</th>
                            </tr>
                            <tr>
                                <th id="date"></th>
                            </tr>
                        </thead>

                    </table>
                    <!-- <h3 class="total-amount">Total Amount:</h3><h3 class="align-right">Tk.600</h3>
                    <h4 class="customer-name">Customer Name:</h4><h4 class="align-right">Shanta Maria</h4>
                    <h4 class="employee-name">Employee Name:</h4><h4 class="align-right">Nazz</h4> -->

                </div>



            </div>


            <div class="order-con-btn">
                <button action="order-han.php" class="form__button cancel" type="button">Cancel</button>
                <button action="order-han.php" class="form__button confirm-order" type="button">Confirm Order</button>
            </div>
        </form>

    </div>

    <footer>
        <p><small>&copy; Copyright 2023 IUTea. All Rights Reserved</small> </p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Get today's date
        var today = new Date();

        // Extract date components
        var day = today.getDate();
        var month = today.getMonth() + 1; // Month is zero-based, so add 1
        var year = today.getFullYear();

        // Format the date as desired (e.g., "MM/DD/YYYY")
        var formattedDate = 'Date: ' + month + '/' + day + '/' + year;

        // Display the date in the HTML element with id "date"
        document.getElementById("date").textContent = formattedDate;
    </script>

</body>

</html>