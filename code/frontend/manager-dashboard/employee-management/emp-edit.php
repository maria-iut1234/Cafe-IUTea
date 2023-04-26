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

    <link href="emp-man.css" rel="stylesheet">

    <title>Employee Edit</title>
</head>

<body>

    <div class="container mt-5">

        <?php include('message.php'); ?>

        <div class="title">
            <h1>Edit Employee</h1>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <!-- <h4>Employee Edit -->
                            <a href="index.php" class="btn btn-danger float-end">BACK</a>
                        <!-- </h4> -->
                    </div>
                    <div class="card-body">

                        <?php
                        if (isset($_GET['emp_id'])) {
                            $emp_id = mysqli_real_escape_string($con, $_GET['emp_id']);
                            $query = "SELECT * FROM employee WHERE e_id='$emp_id' ";
                            $query_run = mysqli_query($con, $query);

                            if (mysqli_num_rows($query_run) > 0) {
                                $emp = mysqli_fetch_array($query_run);
                        ?>
                                <form action="code.php" method="POST">
                                    <input type="hidden" name="emp_id" value="<?= $emp['e_id']; ?>">

                                    <div class="mb-3">
                                        <label>Employee Name</label>
                                        <input type="text" name="name" value="<?= $emp['e_name']; ?>" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label>Employee Email</label>
                                        <input type="email" name="email" value="<?= $emp['e_email']; ?>" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label>Employee Date of Birth</label>
                                        <input type="text" name="dob" value="<?= $emp['e_dob']; ?>" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label>Employee Address</label>
                                        <input type="text" name="address" value="<?= $emp['e_address']; ?>" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <button type="submit" name="update_emp" class="btn btn-primary">
                                            Update Employee
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