<?php
session_start();
require 'dbcon.php';


//delete expired items
// date_default_timezone_set('Asia/Dhaka');
// $today = date('Y-m-d');
// $tomorrow = date('Y-m-d', strtotime($today .' +1 day'));


$sql6 = "SELECT in_id,SUM(o_amount) as amount FROM inventory_orders WHERE e_date<=CURDATE() GROUP BY in_id";
$query6 = mysqli_query($con, $sql6);

$result6 = mysqli_fetch_array($query6);
foreach($query6 as $res6){
    $in_id=$res6['in_id'];
    $sql7 = "SELECT * FROM inventories WHERE in_id = '$in_id'";
    $query_run7 = mysqli_query($con, $sql7);
    $res7 = mysqli_fetch_array($query_run7);
    $newamount = $res7['in_amount']-$res6['amount'];
    $update = "UPDATE inventories SET in_amount = '$newamount' WHERE in_id = '$in_id'";
    $update_run = mysqli_query($con, $update);
    
    //sending notifications
    $in_name=$res7['in_name'];
    $desc = "Some Inventory Items have expired";
    $sql8 = "SELECT * FROM notifications WHERE n_desc = '$in_name'";
    $query_run8 = mysqli_query($con, $sql8);
    if(mysqli_num_rows($query_run8)>0){
        $sql9 = "UPDATE notifications SET n_reason = '$desc', n_status = 0 WHERE n_desc = '$in_name'";
        $query_run9 = mysqli_query($con, $sql9);
        echo "Has expired Update".$in_name;
    }
    else{
        $sql10 = "INSERT INTO `notifications`(`n_id`, `n_desc`,`n_reason`) VALUES ('default','$in_name','$desc')";
        $query_run10 = mysqli_query($con, $sql10);
        echo "Has expired Insert".$in_name;
    }
}

//send notification for expiring items
$sql1 = "SELECT in_id FROM inventory_orders WHERE e_date <= DATE_ADD(CURDATE(), INTERVAL 3 DAY) GROUP BY in_id";
$query1 = mysqli_query($con,$sql1);
foreach($query1 as $res){
    $in_id = $res['in_id'];
    $sql2 = "SELECT * FROM inventories WHERE in_id = $in_id";
    $query_run2 = mysqli_query($con, $sql2);
    $r = mysqli_fetch_array($query_run2);
    $in_name = $r['in_name'];

    $sql3 = "SELECT * FROM notifications WHERE n_desc = '$in_name'";
    $query_run3 = mysqli_query($con, $sql3);
    $desc = "Some Inventory Items will expire within 7 days";
    if(mysqli_num_rows($query_run3)>0){
        // $res3 = mysqli_fetch_array($query_run3);
        // if($res3['n_status']===1){
        //     $sql4 = "UPDATE notifications SET n_reason = '$desc', n_status = 0 WHERE n_desc = '$in_name'";
        //     $query_run4 = mysqli_query($con, $sql4);
        //     echo "About to expire Update ".$in_name;
        // }
        ;
    }
    else{
        $sql5 = "INSERT INTO `notifications`(`n_id`, `n_desc`,`n_reason`) VALUES ('default','$in_name','$desc')";
        $query_run5 = mysqli_query($con, $sql5);
        echo "About to expire Insert ".$in_name;
    }
}



header('location: index.php');
?>