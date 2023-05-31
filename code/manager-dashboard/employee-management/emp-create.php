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
    <link href="../employee-management/src/emp-man.css" rel="stylesheet">
    <link rel="shortcut icon" href="images/logo.ico">


    <link href="../employee-management/src/sidebar.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

    <title>Employee Create</title>
</head>

<body>
    <?php include('message.php'); ?>
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

    <div class="other-btn">
        <a href="index.php" class="btn btn-add float-end">BACK</a>
    </div>
    <div class="container mt-5 create-emp">


        <div class="title">
            <h1>Add New Employee</h1>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <!-- <div class="card-header"> -->
                    <!-- <h4>Employee Add -->
                    <!-- <a href="index.php" class="btn btn-back float-end">BACK</a> -->
                    <!-- </h4> -->
                    <!-- </div> -->
                    <div class="card-body edit-view">
                        <form action="backend.php" method="POST" enctype="multipart/form-data">
                            <div class="pfp">
                                <img src="../../uploads/avatar-default.png" alt="Avatar">
                            </div>
                            <div class="mb-3">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control fix" required>
                            </div>
                            <div class="mb-3">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control fix" required>
                            </div>
                            <div class="mb-3">
                                <label>Date of Birth</label>
                                <input type="date" name="dob" class="form-control fix" required>
                            </div>
                            <div class="mb-3">
                                <label>Address</label>
                                <input type="text" name="address" class="form-control fix" required>
                            </div>
                            <div class="mb-3">
                                <label class="file_button adj">
                                    <input type="file" name="add_image"> <?php echo isset($_FILES['add_image']) ? $_FILES['add_image']['name'] : "Add Employee Image"; ?>
                                </label>
                            </div>
                            <div class="mb-3">
                                <button type="submit" name="save_emp" class="btn adjust">Save Employee</button>
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