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

date_default_timezone_set('Asia/Dhaka');
$date = date("Y-m-d");
$month = date("Y-m");

$daily_revenue = $date;
$daily_expense = $date;
$daily_profit = $date;

$monthly_revenue = $month;
$monthly_expense = $month;
$monthly_profit = $month;

$selectedValue = "null";

if (isset($_POST['submit'])) {
    $selectedValue = $_POST['menu-item-size'];

    $daily_revenue = $_POST['daily-revenue'] ? $_POST['daily-revenue'] : $date;
    $daily_expense = $_POST['daily-expense'] ? $_POST['daily-expense'] : $date;
    $daily_profit = $_POST['daily-profit'] ? $_POST['daily-profit'] : $date;

    $monthly_revenue = $_POST['monthly-revenue'] ? $_POST['monthly-revenue'] : $month;
    $monthly_expense = $_POST['monthly-expense'] ? $_POST['monthly-expense'] : $month;
    $monthly_profit = $_POST['monthly-profit'] ? $_POST['monthly-profit'] : $month;
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
            <li><a href="../notifications/notif.php">Notifications</a></li>
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
                        <option value="null" <?php if ($selectedValue == "null") echo "selected"; ?>>Select Analytics</option>
                        <option value="daily-revenue" <?php if ($selectedValue == "daily-revenue") echo "selected"; ?>>Daily Revenue</option>
                        <option value="daily-expense" <?php if ($selectedValue == "daily-expense") echo "selected"; ?>>Daily Expense</option>
                        <option value="daily-profit" <?php if ($selectedValue == "daily-profit") echo "selected"; ?>>Daily Profit</option>
                        <option value="monthly-revenue" <?php if ($selectedValue == "monthly-revenue") echo "selected"; ?>>Monthly Revenue</option>
                        <option value="monthly-expense" <?php if ($selectedValue == "monthly-expense") echo "selected"; ?>>Monthly Expense</option>
                        <option value="monthly-profit" <?php if ($selectedValue == "monthly-profit") echo "selected"; ?>>Monthly Profit</option>
                    </select>
                </div>

                <div class="null-option" id="nothing-selected">
                    <h1>Select an option please...</h1>
                </div>

                <!-- Daily Revenue Table -->

                <?php

                $daily_revenue_query = "SELECT * FROM orders WHERE order_date = '$daily_revenue'";
                $daily_revenue_query_run = mysqli_query($con, $daily_revenue_query);
                $total_revenue = 0;
                ?>

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

                                <?php
                                if (mysqli_num_rows($daily_revenue_query_run) > 0) {
                                    while ($row = mysqli_fetch_assoc($daily_revenue_query_run)) { ?>
                                        <tr>
                                            <td><?php echo $row['order_id']; ?></td>
                                            <td><?php echo $row['total_price']; ?></td>
                                        </tr>

                                    <?php $total_revenue += $row['total_price'];
                                    }
                                } else { ?>

                                    <td>No data found</td>
                                    <td>No data found</td>

                                <?php
                                }
                                ?>


                            </tbody>
                        </table>
                    </div>

                    <div class="info-table table-align">
                        <table class="an-r">
                            <thead>
                                <tr>
                                    <th>Total Revenue: </th>
                                    <th>Tk. <?php echo $total_revenue; ?></th>
                                </tr>
                                <tr>
                                    <th>Date: </th>
                                    <th><?php echo $daily_revenue; ?></th>
                                </tr>
                            </thead>
                        </table>
                    </div>

                    <div class="date-input table-align">
                        <div class="analytics-bottom-part">
                            <!-- <form method="POST"> -->
                            <input type="date" class="form__input date" name="daily-revenue" autofocus>
                            <button class="form__button an-submit" type="submit" name="submit" id="submit-button">Submit</button>
                            <!-- </form> -->
                        </div>
                    </div>

                </div>

                <!-- Daily Expense Table -->

                <?php

                $daily_expense_query = "SELECT * FROM orders WHERE order_date = '$daily_expense'";
                $daily_expense_query_run = mysqli_query($con, $daily_expense_query);
                $total_expense = 0;
                ?>

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

                                <?php
                                if (mysqli_num_rows($daily_expense_query_run) > 0) {
                                    while ($row = mysqli_fetch_assoc($daily_expense_query_run)) { ?>
                                        <tr>
                                            <td><?php echo $row['order_id']; ?></td>
                                            <td><?php echo $row['total_cost']; ?></td>
                                        </tr>
                                    <?php $total_expense += $row['total_cost'];
                                    }
                                } else { ?>

                                    <td>No data found</td>
                                    <td>No data found</td>

                                <?php
                                }
                                ?>


                            </tbody>
                        </table>
                    </div>

                    <div class="info-table table-align">
                        <table class="an-r">
                            <thead>
                                <tr>
                                    <th>Total Expense: </th>
                                    <th>Tk. <?php echo $total_expense; ?></th>
                                </tr>
                                <tr>
                                    <th>Date: </th>
                                    <th><?php echo $daily_expense; ?></th>
                                </tr>
                            </thead>
                        </table>
                    </div>

                    <div class="date-input table-align">
                        <div class="analytics-bottom-part">
                            <!-- <form method="POST"> -->
                            <input type="date" class="form__input date" name="daily-expense" autofocus>
                            <button class="form__button an-submit" type="submit" name="submit" id="submit-button">Submit</button>
                            <!-- </form> -->
                        </div>
                    </div>

                </div>

                <!-- Daily Profit Table -->

                <?php

                $daily_profit_query = "SELECT * FROM orders WHERE order_date = '$daily_profit'";
                $daily_profit_query_run = mysqli_query($con, $daily_profit_query);
                $total_profit = 0;
                ?>

                <div class="menu-items-table profit" id="table-daily-profit" style="display: none;">
                    <div class="table-align">
                        <table class="tg">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Profit</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                if (mysqli_num_rows($daily_profit_query_run) > 0) {
                                    while ($row = mysqli_fetch_assoc($daily_profit_query_run)) { ?>
                                        <tr>
                                            <td><?php echo $row['order_id']; ?></td>
                                            <td><?php echo $row['total_price'] - $row['total_cost']; ?></td>
                                        </tr>
                                    <?php $total_profit += ($row['total_price'] - $row['total_cost']);
                                    }
                                } else { ?>

                                    <td>No data found</td>
                                    <td>No data found</td>

                                <?php
                                }
                                ?>


                            </tbody>
                        </table>
                    </div>

                    <div class="info-table table-align">
                        <table class="an-r">
                            <thead>
                                <tr>
                                    <th>Total Profit: </th>
                                    <th>Tk. <?php echo $total_profit; ?></th>
                                </tr>
                                <tr>
                                    <th>Date: </th>
                                    <th><?php echo $daily_profit; ?></th>
                                </tr>
                            </thead>
                        </table>
                    </div>

                    <div class="date-input table-align">
                        <div class="analytics-bottom-part">
                            <!-- <form method="POST"> -->
                            <input type="date" class="form__input date" name="daily-profit" autofocus>
                            <button class="form__button an-submit" type="submit" name="submit" id="submit-button">Submit</button>
                            <!-- </form> -->
                        </div>
                    </div>

                </div>




                <!-- Monthly Revenue Table -->

                <?php

                $monthly_revenue_query = "SELECT * FROM orders WHERE DATE_FORMAT(order_date, '%Y-%m') = '$monthly_revenue'";
                $monthly_revenue_query_run = mysqli_query($con, $monthly_revenue_query);
                $total_revenue_monthly = 0;
                ?>

                <div class="menu-items-table revenue" id="table-monthly-revenue" style="display: none;">
                    <div class="table-align">
                        <table class="tg">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                if (mysqli_num_rows($monthly_revenue_query_run) > 0) {
                                    while ($row = mysqli_fetch_assoc($monthly_revenue_query_run)) { ?>
                                        <tr>

                                            <td><?php echo $row['order_id']; ?></td>
                                            <td><?php echo $row['total_price']; ?></td>
                                        </tr>
                                    <?php $total_revenue_monthly += $row['total_price'];
                                    }
                                } else { ?>

                                    <td>No data found</td>
                                    <td>No data found</td>

                                <?php
                                }
                                ?>


                            </tbody>
                        </table>
                    </div>

                    <div class="info-table table-align">
                        <table class="an-r">
                            <thead>
                                <tr>
                                    <th>Total Revenue: </th>
                                    <th>Tk. <?php echo $total_revenue_monthly; ?></th>
                                </tr>
                                <tr>
                                    <th>Month: </th>
                                    <th><?php echo $monthly_revenue; ?></th>
                                </tr>
                            </thead>
                        </table>
                    </div>

                    <div class="date-input table-align">
                        <div class="analytics-bottom-part">
                            <!-- <form method="POST"> -->
                            <input type="month" class="form__input date" name="monthly-revenue" autofocus>
                            <button class="form__button an-submit" type="submit" name="submit" id="submit-button">Submit</button>
                            <!-- </form> -->
                        </div>
                    </div>

                </div>

                <!-- Monthly Expense Table -->

                <?php

                $monthly_expense_query = "SELECT * FROM orders WHERE DATE_FORMAT(order_date, '%Y-%m') = '$monthly_expense'";
                $monthly_expense_query_run = mysqli_query($con, $monthly_expense_query);
                $total_expense_monthly = 0;
                ?>

                <div class="menu-items-table expense" id="table-monthly-expense" style="display: none;">
                    <div class="table-align">
                        <table class="tg">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Cost</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                if (mysqli_num_rows($monthly_expense_query_run) > 0) {
                                    while ($row = mysqli_fetch_assoc($monthly_expense_query_run)) { ?>
                                        <tr>
                                            <td><?php echo $row['order_id']; ?></td>
                                            <td><?php echo $row['total_cost']; ?></td>
                                        </tr>
                                    <?php $total_expense_monthly += $row['total_cost'];
                                    }
                                } else { ?>

                                    <td>No data found</td>
                                    <td>No data found</td>

                                <?php
                                }
                                ?>


                            </tbody>
                        </table>
                    </div>

                    <div class="info-table table-align">
                        <table class="an-r">
                            <thead>
                                <tr>
                                    <th>Total Expense: </th>
                                    <th>Tk. <?php echo $total_expense_monthly; ?></th>
                                </tr>
                                <tr>
                                    <th>Month: </th>
                                    <th><?php echo $monthly_expense; ?></th>
                                </tr>
                            </thead>
                        </table>
                    </div>

                    <div class="date-input table-align">
                        <div class="analytics-bottom-part">
                            <!-- <form method="POST"> -->
                            <input type="month" class="form__input date" name="monthly-expense" autofocus>
                            <button class="form__button an-submit" type="submit" name="submit" id="submit-button">Submit</button>
                            <!-- </form> -->
                        </div>
                    </div>

                </div>

                <!-- Monthly Profit Table -->

                <?php

                $monthly_profit_query = "SELECT * FROM orders WHERE  DATE_FORMAT(order_date, '%Y-%m') = '$monthly_profit'";
                $monthly_profit_query_run = mysqli_query($con, $monthly_profit_query);
                $total_profit_monthly = 0;
                ?>

                <div class="menu-items-table profit" id="table-monthly-profit" style="display: none;">
                    <div class="table-align">
                        <table class="tg">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Profit</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                if (mysqli_num_rows($monthly_profit_query_run) > 0) {
                                    while ($row = mysqli_fetch_assoc($monthly_profit_query_run)) { ?>
                                        <tr>
                                            <td><?php echo $row['order_id']; ?></td>
                                            <td><?php echo $row['total_price'] - $row['total_cost']; ?></td>
                                        </tr>
                                    <?php $total_profit_monthly += ($row['total_price'] - $row['total_cost']);
                                    }
                                } else { ?>

                                    <td>No data found</td>
                                    <td>No data found</td>

                                <?php
                                }
                                ?>


                            </tbody>
                        </table>
                    </div>

                    <div class="info-table table-align">
                        <table class="an-r">
                            <thead>
                                <tr>
                                    <th>Total Profit: </th>
                                    <th>Tk. <?php echo $total_profit_monthly; ?></th>
                                </tr>
                                <tr>
                                    <th>Month: </th>
                                    <th><?php echo $monthly_profit; ?></th>
                                </tr>
                            </thead>
                        </table>
                    </div>

                    <div class="date-input table-align">
                        <div class="analytics-bottom-part">
                            <!-- <form method="POST"> -->
                            <input type="month" class="form__input date" name="monthly-profit" autofocus>
                            <button class="form__button an-submit" type="submit" name="submit" id="submit-button">Submit</button>
                            <!-- </form> -->
                        </div>
                    </div>

                </div>

            </div>

        </form>

    </div>

    <footer>
        <p><small>&copy; Copyright 2023 IUTea. All Rights Reserved</small> </p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    <script src="analytics.js"></script>

</body>

</html>