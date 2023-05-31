<?php
session_start();
require 'dbcon.php';
$messi = '';

if (isset($_SESSION['type']) && $_SESSION['type'] == "manager") {
    $messi = $_SESSION['id'];
    $sub_str = substr($messi, -6, -3);
} else {
    header("location: ../../login/index.php");
}
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="src/notif.css" rel="stylesheet">
    <link href="src/basic.css" rel="stylesheet">
    <link rel="shortcut icon" href="images/logo.ico">
    <link href="src/sidebar.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

    <title>Notifications</title>


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

    <div class="other-btn">
        <a href="../inventory-management/index.php" class="btn btn-add float-end">BACK</a>
    </div>

    <div class="container mt-5">

        <div class="title">
            <h1>Notifications</h1>
        </div>

        <?php include('message.php'); ?>

        <div class="row">
            <div class="col-md-12">
                <div class="card edit-view">

                    <div class="card-body edit-view">
                        <?php
                        $query = "SELECT * FROM notifications";
                        $query_run = mysqli_query($con, $query);
                        if (mysqli_num_rows($query_run) > 0) { ?>
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Restock Ingredient</th>
                                        <th>Status</th>
                                        <th>Description</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($query_run as $notif) {
                                    ?>
                                        <tr>
                                            <td><?= $notif['n_desc']; ?></td>
                                            <td><?= $notif['n_status'] ? "Restocked" : "Not Restocked"; ?></td>
                                            <td><?= $notif['n_reason']; ?></td>
                                            <td>
                                                <button class="btn  <?= $notif['n_status'] ? 'btn-delete' : 'btn-edit' ?> " name="<?= $notif['n_status'] ? 'btn-delete' : 'btn-restock' ?>" type="button" id="<?= $notif['n_desc'] ?>" onclick="openPopupDelete(this.id,this.name)"><?= $notif['n_status'] ? "Remove" : "Restock" ?></button>
                                            </td>
                                        </tr>
                                        <!-- Popup -->
                                        <form action="notif-delete.php" method="POST">
                                            <div class="popup_delete" id="popup_delete">
                                                <h2>Remove Notification?</h2>
                                                <p>Are you sure about removing this Notification?</p>
                                                <input type="hidden" name="in_name" id="in_name">
                                                <div class="popup_button_space">
                                                    <button type="submit" class="employee_button_popup" name="confirmremove">Confirm</button>
                                                </div>
                                                <button type="button" class="employee_button_delete_popup" onclick="closePopupDelete()">Cancel</button>
                                            </div>
                                        </form>

                                        <form action="notif-update.php" method="POST">
                                            <div class="popup_restock" id="popup_restock">
                                                <h2>Restock Units?</h2>
                                                <input type="number" class="form-control" name="in_qty" id="in_qty" placeholder="Enter amount..." required>
                                                <div class="mb-3">
                                                    <label>Expiration Date</label>
                                                    <input type="date" name="expiration" class="form-control" required>
                                                </div>
                                                <input type="hidden" name="i_name" id="i_name">
                                                <div class="popup_button_space">
                                                    <button type="submit" class="employee_button_popup" name="confirmrestock">Confirm</button>
                                                </div>
                                                <button type="button" class="employee_button_delete_popup" onclick="closePopupDelete()">Cancel</button>
                                            </div>
                                        </form>
                                    <?php } ?>

                                </tbody>
                            </table>
                        <?php
                        } else {
                            echo "<h5> No Record Found </h5>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <p><small>&copy; Copyright 2023 IUTea. All Rights Reserved</small> </p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let popupDelete = document.getElementById("popup_delete");
        let popup = document.getElementById("popup_restock");


        function openPopupDelete(id, status) {
            console.log(id);
            if (status === "btn-delete") {
                popupDelete.classList.add("open-popup-delete");
                $('#in_name').val(id);


            } else if (status === "btn-restock") {

                popup.classList.add("open-popup-restock");
                $('#i_name').val(id);
            }

        }

        function closePopupDelete() {
            popup.classList.remove("open-popup-restock");
            popupDelete.classList.remove("open-popup-delete");
        }
    </script>
</body>

</html>