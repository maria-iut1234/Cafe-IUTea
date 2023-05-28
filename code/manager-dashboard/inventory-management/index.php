<?php
session_start();
require 'dbcon.php';

$messi = '';

if (isset($_SESSION['type']) && $_SESSION['type'] == "manager")
    $messi = $_SESSION['id'];
else {
    header("location: ../../login/index.php");
}
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- <link href="bootstrap.css" rel="stylesheet"> -->

    <link href="sidebar.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link href="emp-man.css" rel="stylesheet">

    <link rel="shortcut icon" href="images/logo.ico">

    <title>Inventory Management</title>

</head>

<body>

    <input type="checkbox" id="active" />
    <label for="active" class="menu-btn"><i class="fas fa-bars"></i></label>
    <div class="wrapper">
        <ul>
            <li><img class="iutea-icon" src="images/logo.png"></li>
            <li><a href="../employee-management/index.php">Employee Management</a></li>
            <li><a href="../menu-management/index.php">Menu Management</a></li>
            <li><a href="../inventory-management/index.php">Inventory Management</a></li>
            <li><a href="#">Analytics</a></li>
            <li><a href="#">Settings</a></li>
            <li><a href="<?php echo $messi ? '../../login/logout.php' : '../../login/index.php'; ?>"><?php echo $messi ? 'Log Out' : 'Log In'; ?></a></li>
        </ul>
    </div>

    <div>
        <button class="btn other-btn" type="button" onclick="openPopup()"> Add Invetory Item</button>
        <form action="backend.php" method="POST">
            <div class="popup_add" id="popup_add">
                <h2>Add New Item?</h2>
                <p>What is the Name of the Item You Want to Add?</p>
                <input type="text" class="form-control" name="in_name" id="in_name" placeholder="Enter Name..." required>
                <div class="popup_button_space">
                    <button type="submit" class="employee_button_popup" name="additem">Confirm</button>
                </div>
                <button type="button" class="employee_button_delete_popup" onclick="closePopup()">Cancel</button>
            </div>
        </form>
    </div>

    <div class="container mt-4">



        <div class="title">
            <h1>Inventory Details</h1>
        </div>

        <?php include('message.php'); ?>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">

                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Inventory Name</th>
                                    <th>Inventory Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = "SELECT * FROM inventories";
                                $query_run = mysqli_query($con, $query);

                                if (mysqli_num_rows($query_run) > 0) {
                                    foreach ($query_run as $inv) {
                                ?>
                                        <tr>
                                            <td><?= $inv['in_name']; ?></td>
                                            <td><?= $inv['in_amount']; ?></td>
                                            <td>
                                                <a href="inv-view.php?in_id=<?= $inv['in_id']; ?>&in_name=<?= $inv['in_name']; ?>" class="btn btn-view">Check Stock</a>
                                                <button class="btn btn-edit" type="button" id="<?= $inv['in_id'] ?> " onclick="openPopupRestock(this.id)"> Restock</button>
                                                <button class="btn btn-delete" type="button" id="<?= $inv['in_id'] ?> " onclick="openPopupDelete(this.id)"> Delete</button>
                                            </td>
                                        </tr>
                                        <!-- Restock Section -->
                                        <form action="inv-restock.php" method="POST">
                                            <div class="popup_restock" id="popup_restock">
                                                <h2>How many Units?</h2>
                                                <input type="text" class="form-control" name="in_qty" id="in_qty" placeholder="Enter amount..." required>
                                                <div class="mb-3">
                                                    <label>Expiration Date</label>
                                                    <input type="date" name="expiration" class="form-control" required>
                                                </div>
                                                <input type="hidden" name="in_id" id="in_id">
                                                <div class="popup_button_space">
                                                    <button type="submit" class="employee_button_popup" name="confirmrestock" id="<?= $inv['in_id'] ?>" value="<?= $inv['in_id'] ?>">Confirm</button>
                                                </div>
                                                <button type="button" class="employee_button_delete_popup" onclick="closePopupRestock()">Cancel</button>
                                            </div>
                                        </form>
                                        <!-- Delete Section -->
                                        <form action="inv-delete.php" method="POST">
                                            <div class="popup_delete" id="popup_delete">
                                                <h2>Delete?</h2>
                                                <p>Are you sure about deleting this item all together?</p>
                                                <input type="hidden" name="_id" id="_id">
                                                <div class="popup_button_space">

                                                    <button type="submit" class="employee_button_popup" name="confirmdelete" id="<?= $emp['e_id'] ?>" value="<?= $emp['e_id'] ?>">Confirm</button>
                                                </div>
                                                <button type="button" class="employee_button_delete_popup" onclick="closePopupDelete()">Cancel</button>
                                            </div>
                                        </form>
                                <?php
                                    }
                                } else {
                                    echo "<h5> No Record Found </h5>";
                                }
                                ?>

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let popup = document.getElementById("popup_add");

        function openPopup() {
            popup.classList.add("open-popup");
        }

        function closePopup() {
            popup.classList.remove("open-popup");
        }

        let popupOpen = document.getElementById("popup_restock");

        function openPopupRestock(invID) {
            popupOpen.classList.add("open-popup-restock");
            $('#in_id').val(invID);
        }

        function closePopupRestock() {
            popupOpen.classList.remove("open-popup-restock");
        }

        let popupDelete = document.getElementById("popup_delete");

        function openPopupDelete(invID) {
            popupDelete.classList.add("open-popup-delete");
            $('#_id').val(invID);
        }

        function closePopupDelete() {
            popupDelete.classList.remove("open-popup-delete");
        }
    </script>
</body>

</html>