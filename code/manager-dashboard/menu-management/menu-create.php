<?php
session_start();
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

    <!-- Bootstrap CSS -->
    <link href="menu-man.css" rel="stylesheet">
    <link rel="shortcut icon" href="images/logo.ico">


    <link href="sidebar.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

    <title>menu Create</title>
</head>

<body>
    <?php include('message.php'); ?>
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

    <div class="other-btn">
        <a href="index.php" class="btn btn-add float-end">BACK</a>
    </div>
    <div class="container mt-5 create-menu">


        <div class="title">
            <h1>Add New Menu</h1>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <!-- <div class="card-header"> -->
                    <!-- <h4>menu Add -->
                    <!-- <a href="index.php" class="btn btn-back float-end">BACK</a> -->
                    <!-- </h4> -->
                    <!-- </div> -->
                    <div class="card-body edit-view">
                        <form action="backend.php" method="POST">
                            <div class="pfp">
                                        <img src="./images/default_pfp.png" alt="Avatar">
                                    </div>
                            <div class="mb-3">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control view-menu">
                            </div>
                            <div class="mb-3">
                                <label>Price</label>
                                <input type="text" name="price" class="form-control view-menu">
                            </div>
                            <div class="mb-3">
                                    <label class="file_button">
                                    <input type="file" name="add_image" accept="image/jpg, image/jpeg, image/png"> Add Menu Image
                                    </label>
                            </div>
                            <div class="mb-3">
                                <button type="submit" name="add_menu" class="btn">Save Menu</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>