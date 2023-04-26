<?php
require 'dbcon.php';
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="emp-man.css" rel="stylesheet">

    <link rel="shortcut icon" href="images/logo.ico">

    <title>View Employee</title>
</head>

<body>

    <div class="container mt-5">

        <div class="title">
            <h1>View Employee</h1>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <!-- <h4>View Employee Details -->
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

                                <div class="mb-3">
                                    <label>Employee Name</label>
                                    <p class="form-control view-emp">
                                        <?= $emp['e_name']; ?>
                                    </p>
                                </div>
                                <div class="mb-3">
                                    <label>Employee Email</label>
                                    <p class="form-control view-emp">
                                        <?= $emp['e_email']; ?>
                                    </p>
                                </div>
                                <div class="mb-3">
                                    <label>Employee Date of Birth</label>
                                    <p class="form-control view-emp">
                                        <?= $emp['e_dob']; ?>
                                    </p>
                                </div>
                                <div class="mb-3">
                                    <label>Employee Address</label>
                                    <p class="form-control view-emp">
                                        <?= $emp['e_address']; ?>
                                    </p>
                                </div>

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