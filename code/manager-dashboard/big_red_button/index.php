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

    <link href="src/sidebar.css" rel="stylesheet">
    <link href="src/basic.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link href="src/emp-man.css" rel="stylesheet">
    <link rel="shortcut icon" href="images/logo.ico">
    <style>
        button {
            margin: 13% 45%;
            border-radius: 50%;
            width: 200px;
            height: 200px;
            border: none;
            color: white;
            font-family: Avenir, Arial, sans-serif;
            font-weight: 900;
            font-size: 2.5rem;
            background: #D72713;
            text-shadow: 0 3px 1px rgba(122, 17, 8, .8);
            box-shadow: 0 8px 0 rgb(183, 9, 0),
                0 15px 20px rgba(0, 0, 0, .35);
            text-transform: uppercase;
            transition: .4s all ease-in;
            outline: none;
            cursor: pointer;
            text-align: center;
            -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
        }

        button span {
            position: relative;
            background: #D72713;
        }

        /* fix for IE 11 (and IE8+, although the earlier versions are harder to address) stupidly moving the inner button text on click */
        .pressed {
            padding-top: 3px;
            transform: translateY(4px);
            box-shadow: 0 4px 0 rgb(183, 0, 0),
                0 8px 6px rgba(0, 0, 0, .45);
        }
    </style>
    <title>BIG RED BUTTON</title>

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


    <div class="container mt-4">
        <div class="title">
            <h1>BIG RED BUTTTONN!!!!</h1>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="daily_script.php">
                            <button type="submit" name = "bigred" id="everybodydance"><span>Daily Reset!</span></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>