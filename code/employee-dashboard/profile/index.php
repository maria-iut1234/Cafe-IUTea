<?php
session_start();
require 'dbcon.php';
$messi = '';

if (isset($_SESSION['type']) && $_SESSION['type'] == "employee")
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

    <link href="emp-man.css" rel="stylesheet">
    <link rel="shortcut icon" href="images/logo.ico">


    <link href="sidebar.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

    <title>Employee Profile</title>
</head>

<body>
    <input type="checkbox" id="active" />
    <label for="active" class="menu-btn"><i class="fas fa-bars"></i></label>
    <div class="wrapper">
        <ul>
            <li><img class="iutea-icon" src="images/logo.png"></li>
            <li><a href="../order-form/order-man.php">Order Management</a></li>
            <li><a href="../profile/index.php">Profile</a></li>
            <li><a href="<?php echo $messi ? '../../login/logout.php' : '../../login/index.php'; ?>"><?php echo $messi ? 'Log Out' : 'Log In'; ?></a></li>
        </ul>
    </div>

    <div class="other-btn">
        <a href="../order-form/order-man.php" class="btn btn-add float-end">BACK</a>
    </div>

    <div class="container mt-5">

        <?php include('message.php'); ?>

        <div class="title">
            <h1>Profile</h1>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body edit-view">

                        <?php
                        $emp_id = $_SESSION['id'];
                        $query = "SELECT * FROM employee WHERE e_id='$emp_id' ";
                        $query_run = mysqli_query($con, $query);

                        if (mysqli_num_rows($query_run) > 0) {
                            $emp = mysqli_fetch_array($query_run);
                        ?>
                            <form action="backend.php" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="emp_id" value="<?= $emp['e_id']; ?>">
                                <div class="pfp">
                                    <img src="<?= $emp['e_pfp'] ? "../../uploads/" . $emp['e_pfp'] : "../../uploads/avatar-default.png" ?>" alt="Avatar">
                                </div>
                                <div class="mb-3">
                                    <button class="btn btn-edit" type="button" id="<?= $inv['in_id'] ?> " onclick="openPopupRestock()"> Chage Password</button>
                                </div>
                                <div class="mb-3">
                                    <label>ID</label>
                                    <input type="text" name="id" value="<?= $emp['e_id']; ?>" class="form-control view-emp" readonly>
                                </div>
                                <div class="mb-3">
                                    <label>Name</label>
                                    <input type="text" name="name" value="<?= $emp['e_name']; ?>" class="form-control view-emp">
                                </div>
                                <div class="mb-3">
                                    <label>Email</label>
                                    <input type="email" name="email" value="<?= $emp['e_email']; ?>" class="form-control view-emp" readonly>
                                </div>
                                <div class="mb-3">
                                    <label>Date of Birth</label>
                                    <input type="date" name="dob" value="<?= $emp['e_dob']; ?>" class="form-control view-emp">
                                </div>
                                <div class="mb-3">
                                    <label>Address</label>
                                    <input type="text" name="address" value="<?= $emp['e_address']; ?>" class="form-control view-emp">
                                </div>
                                <div class="mb-3">
                                    <label class="file_button">
                                        <input type="file" name="update_image"> <?php echo isset($_FILES['update_image']) ? $_FILES['update_image']['name'] : "New Profile Image" ?>
                                    </label>
                                </div>
                                <div class="mb-3">
                                    <button type="submit" name="update_emp" class="btn btn-primary">
                                        Update Profile Information
                                    </button>
                                </div>

                            </form>
                        <?php
                        } else {
                            echo "<h4>No Such ID Found</h4>";
                        }
                        ?>
                        <form action="backend.php" method="POST">
                            <div class="popup_delete" id="popup_delete">
                                <h2>Change Password?</h2>

                                <div class="mb-3">
                                    <label>Password</label>
                                    <input type="password" class="form-control" name="pass" id="pass" placeholder="Enter Password..." required>
                                </div>
                                <div class="mb-3">
                                    <label>Confirm Password</label>
                                    <input type="password" class="form-control" name="con_pass" id="con_pass" placeholder="Enter Confirm Password..." required>
                                </div>
                                <input type="hidden" name="id" id="id" value=<?= $_SESSION['id'] ?>>
                                <div class="popup_button_space">
                                    <button type="submit" class="employee_button_popup" name="chng_pass">Confirm</button>
                                </div>
                                <button type="button" class="employee_button_delete_popup" onclick="closePopupRestock()">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let popupOpen = document.getElementById("popup_delete");

        function openPopupRestock() {
            popupOpen.classList.add("open-popup");
        }

        function closePopupRestock() {
            popupOpen.classList.remove("open-popup");
        }
    </script>
</body>

</html>