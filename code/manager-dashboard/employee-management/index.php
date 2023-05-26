<?php
session_start();
require 'dbcon.php';
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

    <title>Employee Management</title>
</head>

<body>

    <input type="checkbox" id="active" />
    <label for="active" class="menu-btn"><i class="fas fa-bars"></i></label>
    <div class="wrapper">
        <ul>
            <li><img class="iutea-icon" src="images/logo.png"></li>
            <li><a href="index.php">Employee Management</a></li>
            <li><a href="#">Menu Management</a></li>
            <li><a href="#">Inventory Management</a></li>
            <li><a href="#">Analytics</a></li>
            <li><a href="#">Setting</a></li>
        </ul>
    </div>

    <div class="container mt-4">

        <?php include('message.php'); ?>

        <div class="title">
            <h1>Employee Details</h1>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <!-- <h4>Employee Details -->
                        <!-- <div class="add-emp"> -->
                        <a href="emp-create.php" class="btn btn-add float-end">Add Employee</a>
                        <!-- </div> -->
                        <!-- </h4> -->
                    </div>
                    <div class="card-body">

                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Employee ID</th>
                                    <th>Employee Name</th>
                                    <th>Email</th>
                                    <th>Date of Birth</th>
                                    <th>Address</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = "SELECT * FROM employee";
                                $query_run = mysqli_query($con, $query);

                                if (mysqli_num_rows($query_run) > 0) {
                                    foreach ($query_run as $emp) {
                                ?>
                                        <tr>
                                            <td><?= $emp['e_id']; ?></td>
                                            <td><?= $emp['e_name']; ?></td>
                                            <td><?= $emp['e_email']; ?></td>
                                            <td><?= $emp['e_dob']; ?></td>
                                            <td><?= $emp['e_address']; ?></td>
                                            <td>
                                                <a href="emp-view.php?emp_id=<?= $emp['e_id']; ?>" class="btn btn-view">View</a>
                                                <a href="emp-edit.php?emp_id=<?= $emp['e_id']; ?>" class="btn btn-edit">Edit</a>
                                                <a href="emp-delete.php?emp_id=<?= $emp['e_id']; ?>" class="btn btn-delete">Delete</a>
                                            </td>
                                        </tr>
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

</body>

</html>