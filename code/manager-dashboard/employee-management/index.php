<?php
session_start();
require 'dbcon.php';
if (isset($_POST['deleteemployeesubmit'])) {
    $id = $_POST['emp_id'];
    $query = "SELECT * FROM employee WHERE e_id='$id' ";
    $query_run = mysqli_query($con, $query);

    if (mysqli_num_rows($query_run) > 0) {
        $sql = "DELETE FROM employee WHERE e_id = '$id'";
        $query_run = mysqli_query($con, $sql);
        $_SESSION['message'] = "Employee Deleted Successfully";
        header('location: index.php');
    } else {
        $_SESSION['message'] = "Employee Could not be Deleted for some reason. The emp id was " . $id;
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
            <li><a href="#">Logout</a></li>
        </ul>
    </div>

    <div class="other-btn">
        <a href="emp-create.php" class="btn btn-add float-end">Add Employee</a>
    </div>

    <div class="container mt-4">

        

        <div class="title">
            <h1>Employee Details</h1>
        </div>

        <?php include('message.php'); ?>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <!-- <div class="card-header"> -->
                    <!-- <h4>Employee Details -->
                    <!-- <div class="add-emp"> -->
                    <!-- <a href="emp-create.php" class="btn btn-add float-end">Add Employee</a> -->
                    <!-- </div> -->
                    <!-- </h4> -->
                    <!-- </div> -->
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
                                                <button class="btn btn-delete" type="button" id="<?= $emp['e_id'] ?> " onclick="openPopup(this.id)"> Delete </button>
                                                <form method="POST">
                                                    <div class="popup_delete" id="popup_delete">
                                                        <h2>Delete?</h2>
                                                        <p>Are you sure about deleting this employee?</p>
                                                        <input type="hidden" name="emp_id" id="delete_id">
                                                        <div class="popup_button_space">

                                                            <button type="submit" class="employee_button_popup" name="deleteemployeesubmit" id="<?= $emp['e_id'] ?>" value="<?= $emp['e_id'] ?>">Confirm</button>
                                                        </div>
                                                        <button type="button" class="employee_button_delete_popup" onclick="closePopup()">Cancel</button>
                                                    </div>
                                                </form>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let popup = document.getElementById("popup_delete");

        function openPopup(empID) {
            popup.classList.add("open-popup");
            $('#delete_id').val(empID);
        }

        function closePopup() {
            popup.classList.remove("open-popup");
        }
    </script>                           
</body>

</html>