<?php
session_start();
require 'dbcon.php';

$messi = '';

if(isset($_SESSION['type']) && $_SESSION['type']=="manager")
    $messi = $_SESSION['id'];
else{
    header("location: ../../login/index.php");
}


if (isset($_POST['deletemenusubmit'])) {
    $id = $_POST['menu_id'];
    $query = "SELECT * FROM menu WHERE menu_id='$id' ";
    $query_run = mysqli_query($con, $query);

    if (mysqli_num_rows($query_run) > 0) {
        $sql = "DELETE FROM menu WHERE menu_id = '$id'";
        $query_run = mysqli_query($con, $sql);
        $_SESSION['message'] = "menu Deleted Successfully";
        header('location: index.php');
    } else {
        $_SESSION['message'] = "menu Could not be Deleted for some reason. The menu id was " . $id;
    }
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
    <link href="menu-man.css" rel="stylesheet">

    <link rel="shortcut icon" href="images/logo.ico">

    <title>Menu Management</title>

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
            <li><a href="<?php echo $messi ? '../../login/logout.php' : '../../login/index.php';?>"><?php echo $messi ? 'Log Out' : 'Log In';?></a></li>
        </ul>
    </div>

    <div class="other-btn">
        <a href="menu-create.php" class="btn btn-add float-end">Add menu</a>
    </div>

    <div class="container mt-4">

        

        <div class="title">
            <h1>Menu Details</h1>
        </div>

        <?php include('message.php'); ?>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <!-- <div class="card-header"> -->
                    <!-- <h4>menu Details -->
                    <!-- <div class="add-menu"> -->
                    <!-- <a href="menu-create.php" class="btn btn-add float-end">Add menu</a> -->
                    <!-- </div> -->
                    <!-- </h4> -->
                    <!-- </div> -->
                    <div class="card-body">

                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Menu Name</th>
                                    <th>Menu Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <?php
                                $query = "SELECT * FROM menu";
                                $query_run = mysqli_query($con, $query);

                                if (mysqli_num_rows($query_run) > 0) {
                                    foreach ($query_run as $menu) {
                                ?>
                                        
                                            <td><?= $menu['menu_name']; ?></td>
                                            <td><?= $menu['menu_price']; ?></td>
                                            <td>
                                                <a href="menu-view.php?menu_id=<?= $menu['menu_id']; ?>" class="btn btn-view">View</a>
                                                <a href="menu-edit.php?menu_id=<?= $menu['menu_id']; ?>" class="btn btn-edit">Edit</a>
                                                <button class="btn btn-delete" type="button" id="<?= $menu['menu_id'] ?> " onclick="openPopup(this.id)"> Delete </button>
                                                <form method="POST">
                                                    <div class="popup_delete" id="popup_delete">
                                                        <h2>Delete?</h2>
                                                        <p>Are you sure about deleting this menu?</p>
                                                        <input type="hidden" name="menu_id" id="deletmenu_id">
                                                        <div class="popup_button_space">
                                                            <button type="submit" class="menu_button_popup" name="deletemenusubmit" id="<?= $menu['menu_id'] ?>" value="<?= $menu['menu_id'] ?>">Confirm</button>
                                                        </div>
                                                        <button type="button" class="menu_button_deletmenu_popup" onclick="closePopup()">Cancel</button>
                                                    </div>
                                                </form>
                                            </td>
                                        
                                <?php
                                    }
                                } else {
                                    echo "<h5> No Record Found </h5>";
                                }
                                ?>
                            </tr>

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
        let popup = document.getElementById("popup_delete");

        function openPopup(menuID) {
            popup.classList.add("open-popup");
            $('#deletmenu_id').val(menuID);
        }

        function closePopup() {
            popup.classList.remove("open-popup");
        }
    </script>                           
</body>

</html>