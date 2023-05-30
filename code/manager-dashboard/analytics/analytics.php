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
                            <tr>
                                <td>hi</td>
                                <td>sometding</td>
                                <td>analytics</td>
                                <td>profit</td>
                                <td>expense</td>
                            </tr>
                        </tbody>


                    </table>

                </div>





            </div>



        </form>

    </div>

    <div>
        <button class="form__button back-btn" type="button">Back</button>
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