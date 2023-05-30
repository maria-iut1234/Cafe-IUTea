<?php
require 'dbcon.php';

if (isset($_POST['place-order'])) {
    $first_name = $_POST['first-name'] ? $_POST['first-name'] : "";
    $last_name = $_POST['last-name'] ? $_POST['last-name'] : "";
    $contact = $_POST['contact'] ? $_POST['contact'] : "";
    $counter = $_POST['menu-item-counter'] ? $_POST['menu-item-counter'] : "";
    $_SESSION['menu-item-counter'] = $counter;

    $ingredient_count = array();
    $ingredients = array();
    $ingredients = [];
    $menu_items_list = array();
    $menu_items_list = [];
    $not_possible_items = array();
    $not_possible_items = [];
    $ingredient_count = array_fill(0, 100, 0);

    $total_price = 0;
    $total_cost = 0;
    $isOrderPossible = true;

    // echo "First Name: " . $first_name . "<br>";
    // echo "Last Name: " . $last_name . "<br>";
    // echo "Contact: " . $contact . "<br>";
    // echo "Menu Item Counter: " . $counter . "<br>";

    for ($i = 0; $i < $counter; $i++) {
        $subtotal = 0;
        $expense = 0;
        $size_multiplier = 1;

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

        $$menuArrayName['name'] = $_POST[$menu_name] ? $_POST[$menu_name] : "null";
        $$menuArrayName['quantity'] = $_POST[$menu_quantity] ? $_POST[$menu_quantity] : 1;
        $$menuArrayName['adds'] = $_POST[$menu_adds] ? $_POST[$menu_adds] : "null";
        $$menuArrayName['size'] = $_POST[$menu_size] ? $_POST[$menu_size] : "null";

        // $$menuArrayName['isPossible'] = true;

        $menu_name_value = $$menuArrayName['name'];
        $menu_size_value = $$menuArrayName['size'];
        $menu_quantity_value = $$menuArrayName['quantity'];
        $menu_adds_value = $$menuArrayName['adds'];



        //checking size values
        if ($menu_size_value == "Medium") {
            $size_multiplier = 2;
        } elseif ($menu_size_value == "Large") {
            $size_multiplier = 4;
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

        //fetching price and id of menu item
        $query = "SELECT * FROM menu WHERE menu_name='$menu_name_value'";
        $query_run = mysqli_query($con, $query);

        if ($query_run) {
            $row = mysqli_fetch_assoc($query_run);
            $menu_price = $row['menu_price'];
            $menu_cost = $row['menu_cost'];
            $$menuArrayName['menuID'] = $row['menu_id'];
            $menu_id_value = $row['menu_id'];

            $subtotal += ($menu_price * $size_multiplier);
            $expense += ($menu_cost * $size_multiplier);
            // echo $subtotal;
        } else {
            echo "Error executing the query: " . mysqli_error($con);
        }

        //multiplying according to quantity
        $subtotal = $subtotal * $menu_quantity_value;
        $expense = $expense * $menu_quantity_value;

        //updating total cost and price
        $total_price += $subtotal;
        $total_cost += $expense;

        $$menuArrayName['subtotal'] = $subtotal ? $subtotal : 0;

        //checking ingredients
        $query_ing = "SELECT * FROM ingredients WHERE menu_id='$menu_id_value'";
        $query_ing_run = mysqli_query($con, $query_ing);

        //fetching inventory details
        $query_inv = "SELECT * FROM inventories";
        $query_inv_run = mysqli_query($con, $query_inv);

        if ($query_ing_run and $query_inv_run) {

            //adding ingredient amount needed
            while ($row_ing = mysqli_fetch_assoc($query_ing_run)) {
                $in_id = $row_ing['in_id'];
                $amount = $row_ing['ing_amount'] * $size_multiplier * $menu_quantity_value;
                $ingredient_count[$in_id] += $amount;

                // //checking if this menu order is possible or not
                // while ($inv = mysqli_fetch_assoc($query_inv_run)) {
                //     if ($inv['in_id'] == $in_id) {
                //         if ($inv['in_amount'] >= $amount) {;
                //         } else {
                //             $$menuArrayName['isPossible'] = false;
                //             $isOrderPossible = false;
                //             // echo $menu_name_value . " " . $amount . "<br>";
                //         }
                //     } else {;
                //     }
                // }
            }
        } else {
            echo "Error executing the query: " . mysqli_error($con);
        }

        if (!in_array($menu_name_value, $menu_items_list)) {
            $menu_items_list[$menu_id_value] = $menu_name_value;
        }

        // Store the menu item data in the session
        $_SESSION[$menuArrayName] = $$menuArrayName;
    }

    //fetching inventory details
    $query_inv = "SELECT * FROM inventories";
    $query_inv_run = mysqli_query($con, $query_inv);

    //checking total ingrediants
    for ($i = 0; $i < count($ingredient_count); $i++) {
        if ($ingredient_count[$i] > 0) {

            while ($inv = mysqli_fetch_assoc($query_inv_run)) {
                if ($inv['in_id'] == $i) {

                    if ($inv['in_amount'] >= $ingredient_count[$i]) {
                    } else {
                        $isOrderPossible = false;
                        array_push($ingredients, $inv['in_name']);
                    }
                    break;
                } else {;
                }
            }
        }
    }

    // $new_inv_amount = $inv['in_amount'] - $ingredient_count[$i];

    // $update = "UPDATE inventories SET in_amount = '$new_inv_amount' WHERE in_id = '$i'";
    // $update_run = mysqli_query($con, $update);

    // if ($update_run) {
    //     echo "Successful" . " " . $new_inv_amount . " " . $i . "<br>";
    // } else {
    //     echo "Error executing the query: " . mysqli_error($con);
    // }


    //checking menu items
    foreach ($menu_items_list as $key => $value) {
        //getting ingredients
        $query_ing = "SELECT DISTINCT in_name FROM ingredients, inventories WHERE ingredients.menu_id='$key'";
        $query_ing_run = mysqli_query($con, $query_ing);

        if ($query_ing_run) {
            while ($row_ing = mysqli_fetch_assoc($query_ing_run)) {
                if (in_array($row_ing['in_name'], $ingredients)) {
                    array_push($not_possible_items, $value);
                }
            }
        } else {
            echo "Error executing the query: " . mysqli_error($con);
        }
    }

    if ($isOrderPossible) {
        $order_info = array();

        $order_info['total_price'] = $total_price;
        $order_info['total_cost'] = $total_cost;
        $order_info['c_name'] = $first_name . " " . $last_name;
        $order_info['c_contact'] = $contact;
        $order_info['e_name'] = "NazzzzZ";

        $_SESSION['order-info'] = $order_info;
        $_SESSION['ingredient-count'] = $ingredient_count;

        header("Location: order-con.php");
    } else {

        $_SESSION['ingredients'] = $ingredients;
        $_SESSION['menu_items'] = $not_possible_items;

        $ingredient_count = [];
        $ingredients = [];
        $menu_items_list = [];
        $not_possible_items = [];
        header("Location: error-order.php");
    }
}
