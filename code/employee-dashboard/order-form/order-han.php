<?php
require 'dbcon.php';

if (isset($_POST['place-order'])) {
    $first_name = $_POST['first-name'] ? $_POST['first-name'] : "";
    $last_name = $_POST['last-name'] ? $_POST['last-name'] : "";
    $contact = $_POST['contact'] ? $_POST['contact'] : "";
    $counter = $_POST['menu-item-counter'] ? $_POST['menu-item-counter'] : "";
    $_SESSION['menu-item-counter'] = $counter;

    $total = 0;

    // echo "First Name: " . $first_name . "<br>";
    // echo "Last Name: " . $last_name . "<br>";
    // echo "Contact: " . $contact . "<br>";
    // echo "Menu Item Counter: " . $counter . "<br>";

    for ($i = 0; $i < $counter; $i++) {
        $subtotal = 0;

        $menuArrayName = 'menu' . $i;
        $$menuArrayName = array();

        $menu_name = 'menu-item-name-' . $i;
        $menu_quantity = 'menu-item-quantity-' . $i;
        $menu_size = 'menu-item-size-' . $i;
        $menu_adds = 'menu-item-adds-' . $i;

        // echo $_POST[$menu_name] . "<br>";
        // echo $_POST[$menu_quantity] . "<br>";
        // echo $_POST[$menu_size] . "<br>";
        // echo $_POST[$menu_adds] . "<br>";

        $$menuArrayName['name'] = $_POST[$menu_name] ? $_POST[$menu_name] : "";
        $$menuArrayName['quantity'] = $_POST[$menu_quantity] ? $_POST[$menu_quantity] : "";
        $$menuArrayName['adds'] = $_POST[$menu_adds] ? $_POST[$menu_adds] : "";
        $$menuArrayName['size'] = $_POST[$menu_size] ? $_POST[$menu_size] : "";

        $menu_name_value = $$menuArrayName['name'];
        $menu_size_value = $$menuArrayName['size'];
        $menu_quantity_value = $$menuArrayName['quantity'];
        $menu_adds_value = $$menuArrayName['adds'];

        //checking size values
        if ($menu_size_value == "Medium") {
            $subtotal += 20;
        } elseif ($menu_size_value == "Large") {
            $subtotal += 50;
        } else {;
        }

        //checking add-ons
        if ($menu_adds_value == "Caramel") {
            $subtotal += 50;
        } elseif ($menu_adds_value == "Vanilla") {
            $subtotal += 30;
        } elseif ($menu_adds_value == "Hazelnut") {
            $subtotal += 80;
        } elseif ($menu_adds_value == "Lactose-Free") {
            $subtotal += 30;
        } else {;
        }

        //fetching price of menu item
        $query = "SELECT menu_price FROM menu WHERE menu_name='$menu_name_value'";
        $query_run = mysqli_query($con, $query);

        if ($query_run) {
            $row = mysqli_fetch_assoc($query_run);
            $menu_price = $row['menu_price'];
            $subtotal += $menu_price;
            // echo $subtotal;
        } else {
            echo "Error executing the query: " . mysqli_error($con);
        }

        $subtotal = $subtotal * $menu_quantity_value;
        $total += $subtotal;

        $$menuArrayName['subtotal'] = $subtotal ? $subtotal : 0;

        // Store the menu item data in the session
        $_SESSION[$menuArrayName] = $$menuArrayName;

        // Access and display the elements in the array
        // echo 'Array ' . $i . ': ';
        // foreach ($$menuArrayName as $key => $value) {
        //     echo $key . ' => ' . $value . ', ';
        // }
        // echo '<br>';
    }

    $order_info = array();

    $order_info['total'] = $total;
    $order_info['c_name'] = $first_name . " " . $last_name;
    $order_info['c_contact'] = $contact;
    $order_info['e_name'] = "NazzzzZ";

    $_SESSION['order-info'] = $order_info;

    header("Location: order-con.php");
}
