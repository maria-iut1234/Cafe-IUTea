<?php
session_start();
require 'dbcon.php';
$messi = '';

if(isset($_SESSION['type']) && $_SESSION['type']=="manager")
    $messi = $_SESSION['id'];
else{
    header("location: ../../login/index.php");
}
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="menu-man.css" rel="stylesheet">

    <link rel="shortcut icon" href="images/logo.ico">


    <!-- <link href="bootstrap.css" rel="stylesheet"> -->

    <link href="sidebar.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

    <title>View menu</title>


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
            <li><a href="<?php echo $mess ? '../../login/logout.php' : '../../login/index.php';?>"><?php echo $messi ? 'Log Out' : 'Log In';?></a></li>
        </ul>
    </div>

    <div class="other-btn">
        <a href="index.php" class="btn btn-add float-end">BACK</a>
    </div>

    <div class="container mt-5">

        <div class="title">
            <h1>View menu</h1>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card edit-view">
                    <!-- <div class="card-header"> -->
                    <!-- <h4>View menu Details -->
                    <!-- <a href="index.php" class="btn btn-danger float-end">BACK</a> -->
                    <!-- </h4> -->
                    <!-- </div> -->
                    <div class="card-body edit-view">

                        <?php
                        if (isset($_GET['menu_id'])) {
                            $menu_id = mysqli_real_escape_string($con, $_GET['menu_id']);
                            $query = "SELECT * FROM menu WHERE menu_id='$menu_id' ";
                            $query_run = mysqli_query($con, $query);
                            if (mysqli_num_rows($query_run) > 0) {
                                $menu = mysqli_fetch_array($query_run);
                        

                               
                        ?>
                            
                            <form action ="backend.php" method="POST">
                                <div class="mb-3">
                                    <label>Menu Picture</label>
                                    <div class="pfp">
                                        <img src="./images/default_pfp.png" alt="Avatar">
                                    </div>
                                </div>
                                <input type="hidden" class="form-control view-menu" name= "menu_id" value="<?= $menu['menu_id']; ?>">
                                <div class="mb-3">
                                    <label>Menu Name</label>
                                    <input type="text" class="form-control view-menu" name= "menu_name" value="<?= $menu['menu_name']; ?>">
                                </div>
                                <div class="mb-3">
                                    <label>Menu Price</label>
                                    <input type="text" class="form-control view-menu" name= "menu_price" value="<?= $menu['menu_price']; ?>">
                                </div>
                                <div class="mb-3">
                                        <button type="submit" name="update_menu" class="btn btn-primary">
                                            Update Menu
                                        </button>
                                </div>
                            </form>
                        <?php
                            } else {
                                echo "<h4>No Such ID Found</h4>";
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>