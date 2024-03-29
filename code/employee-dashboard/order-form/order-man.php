<?php
session_start();
require 'dbcon.php';
require 'order-han.php';

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

    <link href="src/chosen.css" rel="stylesheet">
    <link href="src/basic.css" rel="stylesheet">
    <link href="src/sidebar.css" rel="stylesheet">
    <link href="src/form.css" rel="stylesheet">
    <link href="src/order-man.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

    <link rel="shortcut icon" href="images/logo.ico">

    <title>Order Management</title>

</head>

<body>

    <header>
        <h1>Welcome <?=$sub_str?$sub_str:"Employee"?></h1>
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

    <!-- <div class="other-btn">
        <a href="#" class="btn btn-add float-end">Add Employee</a>
    </div> -->

    <div class="container mt-4">
        <div class="title">
            <h1>Order Management</h1>
        </div>
    </div>

    <?php
    $res = mysqli_query($con, "SELECT * FROM menu");
    ?>

    <div class="order-container">
        <form method="POST" class="order-form">
            <div class="form__input-group customer-name">
                <input type="text" class="form__input first-name" name="first-name" autofocus placeholder="Enter First Name" required>
                <input type="text" class="form__input last-name" name="last-name" autofocus placeholder="Enter Last Name">
            </div>
            <div class="form__input-group">
                <input type="text" class="form__input" name="contact" autofocus placeholder="Enter Customer Contact" required>
            </div>
            <div class="menu-items-container">
                <div class="form__input-group add-menu" id="add-menu-section" style="display: none;">

                    <select data-placeholder="Add Menu Item" name='menu-item-name' class="form__input menu-name menu-item-name">
                        <option value="" disabled selected>Add Menu Item</option>
                        <?php
                        while ($row = mysqli_fetch_array($res)) {
                            echo "<option>$row[menu_name]</option>";
                        }
                        ?>
                    </select>

                    <select class="form__input menu-item-size" name="menu-item-size">
                        <option value="" disabled selected>Size</option>
                        <option value="Small">Small</option>
                        <option value="Medium">Medium</option>
                        <option value="Large">Large</option>
                    </select>

                    <select class="form__input menu-item-adds" name="menu-item-adds">
                        <option value="" disabled selected>Select Add-Ons</option>
                        <option value="Caramel">Caramel +Tk.50</option>
                        <option value="Vanilla">Vanilla +Tk.30</option>
                        <option value="Lactose-Free">Lactose-Free +Tk.30</option>
                        <option value="Hazelnut">Hazelnut +Tk.80</option>
                    </select>

                    <input type="text" class="form__input menu-item-quantity" name="menu-item-quantity" autofocus placeholder="Quantity">

                    <button class="clear-menu-btn" id="clear-menu-btn" type="button"><i class="fa fa-times"></i></button>
                </div>
            </div>

            <input id="menu-item-counter" name="menu-item-counter" type="hidden" value="">

            <button class="form__button add-menu-btn" id="add-menu-btn" type="button">Add Menu Item</button>

            <button action="order-han.php" class="form__button place-order" type="submit" name="place-order">Place Order</button>
        </form>

    </div>

    <footer>
        <p><small>&copy; Copyright 2023 IUTea. All Rights Reserved</small> </p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>
    <script src="order-man.js"></script>

</body>

</html>