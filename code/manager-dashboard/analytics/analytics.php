<?php
session_start();
require 'dbcon.php';

$messi = '';

if (isset($_SESSION['type']) && $_SESSION['type'] == "employee")
    $messi = $_SESSION['id'];
$sub_str = substr($messi, -6, -3);
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
    <link href="src/analytics.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

    <link rel="shortcut icon" href="images/logo.ico">

    <title>Analytics</title>

</head>

<body>

    <header>
        <h1>Welcome <?= $sub_str ? $sub_str : "Manager" ?></h1>
    </header>

    <input type="checkbox" id="active" />
    <label for="active" class="menu-btn"><i class="fas fa-bars"></i></label>
    <div class="wrapper">
        <ul>
            <li><img class="iutea-icon" src="images/logo.png"></li>
            <li><a href="../employee-management/index.php">Employee Management</a></li>
            <li><a href="../inventory-management/index.php">Inventory Management</a></li>
            <li><a href="../menu-management/index.php">Menu Management</a></li>
            <li><a href="../analytics/analytics.php">Analytics</a></li>
            <li><a href="../profile/index.php">Settings</a></li>
            <li><a href="<?php echo $messi ? '../../login/logout.php' : '../../login/index.php'; ?>"><?php echo $messi ? 'Log Out' : 'Log In'; ?></a></li>
        </ul>
    </div>

    <!-- <div class="other-btn">
        <a href="#" class="btn btn-add float-end">Add Employee</a>
    </div> -->

    <div class="container mt-4">
        <div class="title">
            <h1>Analytics</h1>
        </div>
    </div>

    <div class="lottie-analytics">

        <lottie-player class="analytics-two" src="images/analytics2.json" background="#F2F7F2" speed="1" style="width: 200px; height: 200px;" autoplay></lottie-player>

        <lottie-player class="analytics-one" src="images/analytics1.json" background="#F2F7F2" speed="1" style="width: 500px; height: 400px;" autoplay></lottie-player>

    </div>

    <div class="order-container order-confirm">
        <form method="POST" class="order-form order-confirm">
            <div class="order-confirm-form">
                <div class="top-part">
                    <h2 class="menu-items-h2">Analytics:</h2>
                    <select class="form__input menu-item-size analytics" name="menu-item-size" onchange="handleAnalyticsOption(this.value)">
                        <option value="null" disabled selected>Select Analytics</option>
                        <option value="daily-revenue">Daily Revenue</option>
                        <option value="daily-expense">Daily Expense</option>
                        <option value="daily-profit">Daily Profit</option>
                    </select>
                </div>

                <div class="null-option" id="nothing-selected">
                    <h1>Select an option please...</h1>
                </div>

                <div class="menu-items-table revenue" id="table-daily-revenue" style="display: none;">
                    <div class="table-align">
                        <table class="tg">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>hi</td>
                                    <td>sometding</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="info-table table-align">
                        <table>
                            <thead>
                                <tr>
                                    <th>Total Revenue: </th>
                                    <th>Tk.150000</th>
                                </tr>
                            </thead>

                        </table>
                    </div>

                </div>

                <div class="menu-items-table expense" id="table-daily-expense" style="display: none;">
                    <div class="table-align">
                        <table class="tg">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Cost</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>this</td>
                                    <td>is</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="info-table table-align">
                        <table>
                            <thead>
                                <tr>
                                    <th>Total Expense: </th>
                                    <th>Tk.150000</th>
                                </tr>
                            </thead>

                        </table>

                    </div>
                </div>



        </form>

    </div>

    <!-- <div>
        <button class="form__button back-btn" type="button">Back</button>
    </div> -->

    <footer>
        <p><small>&copy; Copyright 2023 IUTea. All Rights Reserved</small> </p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    <!-- <script src="order-con.js"></script> -->
    <script>
        function handleAnalyticsOption(value) {
            const revenueTable = document.getElementById("table-daily-revenue");
            const expenseTable = document.getElementById("table-daily-expense");
            const nothing = document.getElementById("nothing-selected");

            if (value === "daily-revenue") {
                revenueTable.style.display = "block";
                expenseTable.style.display = "none";
                nothing.style.display = "none";

            } else if (value === "daily-expense") {
                revenueTable.style.display = "none";
                expenseTable.style.display = "block";
                nothing.style.display = "none";

            } else if (value === "null") {
                revenueTable.style.display = "none";
                expenseTable.style.display = "none";
                nothing.style.display = "block";

            } else {
                revenueTable.style.display = "none";
                expenseTable.style.display = "none";
                nothing.style.display = "none";
            }
        }
    </script>

</body>

</html>