<?php
session_start();
require 'dbcon.php';
$messi = '';

if (isset($_SESSION['type']) && $_SESSION['type'] == "manager")
    $messi = $_SESSION['id'];
else {
    header("location: ../../login/index.php");
}
$res = mysqli_query($con, "SELECT * FROM inventories");
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="src/menu-man.css" rel="stylesheet">
    <link rel="shortcut icon" href="images/logo.ico">


    <link href="src/sidebar.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>
    <link href="src/chosen.css" rel="stylesheet">
    </link>

    <title>Menu Edit</title>
</head>

<body>
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

    <div class="container mt-5">

        <?php
        $menu_id = mysqli_real_escape_string($con, $_GET['menu_id']);
        $sql = "SELECT * FROM menu WHERE menu_id = $menu_id";
        $query_run = mysqli_query($con, $sql);
        if (mysqli_num_rows($query_run) > 0) {
            $menu = mysqli_fetch_array($query_run);
        }
        ?>

        <div class="title">
            <h1><?= $menu['menu_name'] ?></h1>
        </div>
        <?php include('message.php'); ?>

        <div class="row">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-body">
                        <div class="bod edit-view">
                            <?php
                            if (isset($_GET['menu_id'])) {
                                $menu_id = $_GET['menu_id'];
                                $query = "SELECT * FROM menu WHERE menu_id='$menu_id' ";
                                $query_run = mysqli_query($con, $query);
                                $menu = mysqli_fetch_array($query_run);
                            ?>
                                <form action="backend.php" method="POST">
                                    <input type="hidden" name="menu_id" value="<?= $menu_id; ?>">
                                    <div class="mb-3">
                                        <div class="mb-3">
                                            <div class="pfp">
                                                <img src="<?= $menu['menu_pfp'] ? "../../uploads/" . $menu['menu_pfp'] : "./images/default_pfp.png" ?>" alt="Avatar">
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <select id='search' data-placeholder="Search Ingredient Name" name="in_name" class="form-select" required>
                                                <option disabled selected>Click to Select or Search Ingredient</option>
                                                <?php
                                                while ($row = mysqli_fetch_array($res)) {
                                                    echo "<option>$row[in_name]</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <input type="number" name="in_amount" placeholder="Enter an amount" class="form-input" required>
                                        </div>
                                        <div class="mb-3">
                                            <button type="submit" name="add_ing" class="btn btn-primary adjust">
                                                Add Ingredient
                                            </button>
                                        </div>
                                    </div>
                                    <div class="mb-3">

                                    </div>

                                </form>
                            <?php
                            } else {
                                echo "<h4>No Such ID Found</h4>";
                            }
                            ?>
                        </div>
                        <div class="bodbod edit-view">
                            <?php $query = "SELECT * FROM ingredients WHERE menu_id='$menu_id' order by ing_amount";
                            $query_run = mysqli_query($con, $query);
                            if (mysqli_num_rows($query_run) > 0) {
                            ?>
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Ingredient Name</th>
                                            <th>Ingredient Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($query_run as $ing) {
                                            $in_id = $ing['in_id'];
                                            $sql = "SELECT * FROM inventories WHERE in_id='$in_id'";
                                            $query_run = mysqli_query($con, $sql);
                                            $name = mysqli_fetch_array($query_run);
                                        ?>
                                            <tr>
                                                <td><?= $name['in_name']; ?></td>
                                                <td><?= $ing['ing_amount']; ?></td>
                                            </tr>
                                        <?php
                                        }
                                        ?>

                                    </tbody>
                                </table>
                            <?php
                            } else {
                                echo "<h5> No Record Found </h5>";
                            }
                            ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $("#search").chosen({
            width: "100%"
        });
    </script>
</body>

</html>