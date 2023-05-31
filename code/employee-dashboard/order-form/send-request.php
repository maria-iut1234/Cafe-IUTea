<?php
session_start();
require 'dbcon.php';

$messi = '';

if(isset($_SESSION['type']) && $_SESSION['type']=="employee")
{
    $messi = $_SESSION['id'];
    $sub_str = substr($messi, -6, -3);   
    
} else{
    header("location: ../../login/index.php");
}

$ingredients = $_SESSION['ingredients'];

for ($i = 0; $i < count($ingredients); $i++) {
    $desc = $ingredients[$i];

    $check = "SELECT n_desc FROM notifications WHERE n_desc='$desc'";
    $check_run = mysqli_query($con, $check);

    if ($check_run) {
        if (mysqli_fetch_assoc($check_run) > 0) {
        } else {
            $reason = "Restock Popular Item Ingredient";
            $query = "INSERT INTO notifications (n_desc,n_reason) VALUES ('$desc','$reason')";
            $query_run = mysqli_query($con, $query);

            if ($query_run) {
            } else {
                echo "Error executing the query: " . mysqli_error($con);
            }
        }
    } else {
        echo "Error executing the query: " . mysqli_error($con);
    }
}

?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="refresh" content="5;url=request-sent.php">

    <link href="src/sidebar.css" rel="stylesheet">
    <link href="src/form.css" rel="stylesheet">
    <link href="src/order-man.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

    <link rel="shortcut icon" href="images/logo.ico">

    <title>Order Confirmation</title>

</head>

<body>

    <div class="lottie-loading">
        <lottie-player src="images/loading.json" background="#F2F7F2" speed="1" style="width: 400px; height: 400px;" autoplay loop></lottie-player>
    </div>

    <div class="loading-text">
        <h1>Please wait while request is being sent...</h1>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    <script src="order-con.js"></script>

</body>

</html>