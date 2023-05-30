<?php
session_start();
require 'dbcon.php';
$messi = '';

if (isset($_SESSION['type']) && $_SESSION['type'] == "manager")
    //     $messi = $_SESSION['id'];
    // else {
    //     header("location: ../../login/index.php");
    // }
    // if (!isset($_GET['in_id'])) {
    //     header("location: index.php ");
    // }
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="notif.css" rel="stylesheet">
    <link rel="shortcut icon" href="images/logo.ico">
    <link href="sidebar.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

    <title>Notifications</title>


</head>

<body>
    <input type="checkbox" id="active" />
    <label for="active" class="menu-btn"><i class="fas fa-bars"></i></label>
    <div class="wrapper">
        <ul>
            <li><img class="iutea-icon" src="images/logo.png"></li>
            <li><a href="../employee-management/index.php">Employee Management</a></li>
            <li><a href="../inventory-management/index.php">Inventory Management</a></li>
            <li><a href="../menu-management/index.php">Menu Management</a></li>
            <li><a href="#">Analytics</a></li>
            <li><a href="../profile/index.php">Settings</a></li>
            <li><a href="<?php echo $messi ? '../../login/logout.php' : '../../login/index.php'; ?>"><?php echo $messi ? 'Log Out' : 'Log In'; ?></a></li>
        </ul>
    </div>

    <div class="container mt-5">

        <div class="title">
            <h1>Notifications</h1>
        </div>

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
                                            <td>
                                                <button class="btn  <?= $notif['n_status'] ? 'btn-edit' : 'btn-delete'; ?> " type="button" id="<?= $notif['n_id'] ?> " onclick="openPopupDelete(this.id)">Change Status</button>
                                            </td>
                                        </tr>
                                        <!-- Popup -->
                                        <form action="notif-update.php" method="POST">
                                            <div class="popup_delete" id="popup_delete">
                                                <h2>Change Status?</h2>
                                                <p>Are you sure about changing the status to Restocked?</p>
                                                <input type="hidden" name="_id" id="_id" value="<?= $notif['n_id'] ?>">
                                                <div class="popup_button_space">

                                                    <button type="submit" class="employee_button_popup" name="confirmdelete" id="<?= $notif['n_id'] ?>" value="<?= $notif['n_id'] ?>">Confirm</button>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
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