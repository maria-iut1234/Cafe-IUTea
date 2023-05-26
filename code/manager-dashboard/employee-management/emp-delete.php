<?php
session_start();
require 'dbcon.php';


if (isset($_GET['emp_id'])) {
                            $emp_id = mysqli_real_escape_string($con, $_GET['emp_id']);
                            $query = "SELECT * FROM employee WHERE e_id='$emp_id' ";
                            $query_run = mysqli_query($con, $query);

                            if (mysqli_num_rows($query_run) > 0) {
                                $sql = "DELETE FROM employee WHERE e_id = '$emp_id'";
                                $query_run = mysqli_query($con, $sql);
                                $_SESSION['message'] = "Employee Deleted Successfully";
                                header('location: index.php');
                            }
                        }
