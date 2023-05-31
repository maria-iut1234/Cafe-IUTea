<?php
session_start();
require 'dbcon.php';
$messi = '';

if (isset($_SESSION['type']) && $_SESSION['type'] == "manager") {
    $messi = $_SESSION['id'];
    $sub_str = substr($messi, -6, -3);
} else {
    header("location: ../../login/index.php");
}
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="src/emp-man.css" rel="stylesheet">
    <link href="src/basic.css" rel="stylesheet">
    <link rel="shortcut icon" href="images/logo.ico">


    <link href="src/sidebar.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

    <title>Manager Profile</title>
</head>

<body>
    <header>
        <h1>Welcome <?= $sub_str ? $sub_str : "Manager" ?></h1>
    </header>

    <input type="checkbox" id="active" />
    <label for="active" class="menu-btn"><i class="fas fa-bars"></i></label>
    <div class="wrapper">
        <ul>
            <li><img class="iutea-icon" src="images/logo.png"></li>
            <li><a href="../employee-management/index.php">Employee Management</a></li>
            <li><a href="../inventory-management/index.php">Inventory Management</a></li>
            <li><a href="../menu-management/index.php">Menu Management</a></li>
            <li><a href="../analytics/analytics.php">Analytics</a></li>
            <li><a href="../notifications/notif.php">Notifications</a></li>
            <li><a href="../profile/index.php">Settings</a></li>
            <li><a href="<?php echo $messi ? '../../login/logout.php' : '../../login/index.php'; ?>"><?php echo $messi ? 'Log Out' : 'Log In'; ?></a></li>
        </ul>
    </div>

    <div class="other-btn">
        <a href="../employee-management/index.php" class="btn btn-add float-end">BACK</a>
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
                        $m_id = $_SESSION['id'];
                        $query = "SELECT * FROM manager WHERE m_id='$m_id' ";
                        $query_run = mysqli_query($con, $query);

                        if (mysqli_num_rows($query_run) > 0) {
                            $man = mysqli_fetch_array($query_run);
                        ?>
                            <form action="backend.php" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="m_id" value="<?= $man['m_id']; ?>">
                                <div class="pfp">
                                    <img src="<?= $man['m_pfp'] ? "../../uploads/" . $man['m_pfp'] : "../../uploads/avatar-default.png" ?>" alt="Avatar">
                                </div>
                                <div class="mb-3">
                                    <button class="btn btn-edit adjust" type="button" id="<?= $inv['in_id'] ?> " onclick="openPopupRestock()"> Chage Password</button>
                                </div>
                                <div class="mb-3">
                                    <label class="mb-4">ID</label>
                                    <input type="text" name="id" value="<?= $man['m_id']; ?>" class="form-control fix" readonly>
                                </div>
                                <div class="mb-3">
                                    <label class="mb-4">Name</label>
                                    <input type="text" name="name" value="<?= $man['m_name']; ?>" class="form-control fix">
                                </div>
                                <div class="mb-3">
                                    <label class="mb-4">Email</label>
                                    <input type="email" name="email" value="<?= $man['m_email']; ?>" class="form-control fix" readonly>
                                </div>
                                <div class="mb-3">
                                    <label class="mb-4">Date of Birth</label>
                                    <input type="date" name="dob" value="<?= $man['m_dob']; ?>" class="form-control fix">
                                </div>
                                <div class="mb-3">
                                    <label class="mb-4">Address</label>
                                    <input type="text" name="address" value="<?= $man['m_address']; ?>" class="form-control fix">
                                </div>
                                <div class="mb-3">
                                    <label class="file_button adj">
                                        <input type="file" name="update_image"> <?php echo isset($_FILES['update_image']) ? $_FILES['update_image']['name'] : "New Profile Image" ?>
                                    </label>
                                </div>
                                <div class="mb-3">
                                    <button type="submit" name="update_man" class="btn btn-primary adjust">
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
                                    <input type="password" class="form-control" name="pass" id="pass" placeholder="Enter Password..." required>
                                </div>
                                <div class="mb-3">
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

    <footer>
        <p><small>&copy; Copyright 2023 IUTea. All Rights Reserved</small> </p>
    </footer>

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