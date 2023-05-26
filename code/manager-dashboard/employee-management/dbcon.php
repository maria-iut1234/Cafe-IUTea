<?php

$con = mysqli_connect("localhost","root","","dbms");

if(!$con){
    die('Connection Failed'. mysqli_connect_error());
}
