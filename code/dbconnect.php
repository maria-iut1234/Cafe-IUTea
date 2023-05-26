<?php
    $conn = new mysqli('localhost','root','','dbms');

    if(!$conn){
        die('Connection Failed'. mysqli_connect_error());
    }
?>