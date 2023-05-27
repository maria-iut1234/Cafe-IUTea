<?php
include "../dbconnect.php";
session_start();
if(isset($_SESSION['id'])){
    include "logout.php";
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8" />
    <title>Login Form</title>
    <link rel="stylesheet" href="./src/emp-man.css" />
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<?php

$email = $password = $error = '';

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    if (isset($_POST['type'])) {
        $type = $_POST['type'];
    } else {
        $type = "Employee";
    }

    if ($conn->connect_error) {
        die('Connection Failed : ' . $conn->connect_error);
    } 
    else 
    {
        if ($type == "Employee") {
            $sql = "SELECT * FROM employee WHERE `e_email` = ? LIMIT 1";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                echo "There was an error in preparing";
                exit();
            } else {
                mysqli_stmt_bind_param($stmt, "s", $email);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                if (!$row = mysqli_fetch_assoc($result)) {
                    $error = 'Invalid email!';
                } else {
                    if (password_verify($password, $row['e_password'])) {
                        $_SESSION['name'] = $row['e_name'];
                        $_SESSION['id'] = $row['e_id'];
                        $_SESSION['type'] = "employee";
                        header('location: success');
                    } else {
                        $error = 'Invalid password!';
                    }
                }
            }
        } else 
        {
            $sql = "SELECT * FROM manager WHERE `m_email` = ? LIMIT 1";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                echo "There was an error in preparing";
                exit();
            } else {
                mysqli_stmt_bind_param($stmt, "s", $email);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                if (!$row = mysqli_fetch_assoc($result)) {
                    $error = 'Invalid email!';
                } else {
                    if (password_verify($password, $row['m_password'])) {
                        $_SESSION['name'] = $row['m_name'];
                        $_SESSION['id'] = $row['m_id'];
                        $_SESSION['type'] = "manager";
                        header('location: ../manager-dashboard/employee-management/index.php');
                    } else {
                        $error = 'Invalid password!';
                    }
                }
            }
        }
    }
}
?>
<!--Login form-->
<div class="container">
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" class="form" id="login">
        <h1 class="form__title">Login</h1>
        <div class="form__message form__message--error"></div>
        <div class="form__input-group">
            <input type="text" id="email" class="form__input" autofocus placeholder="Enter Email" name="email" required>
            <div class="form__input-error-message"></div>
        </div>
        <div class="form__input-group">
            <input type="password" id="password" class="form__input" autofocus placeholder="Enter Password" name="password" required>
            <div class="form__input-error-message">
                <?php echo $error ? $error : null; ?>
            </div>
        </div>
        <div class="form__input-group">
            <select class="form__input" id="type" name="type">
                <option>Employee</option>
                <option>Manager</option>
            </select>
        </div>
        <button class="form__button" type="submit" name="submit">Continue</button>
        <?php
        if (isset($_GET["newpassword"])) {
            if ($_GET["newpassword"] == "passwordUpdated") {
                echo '<p class="form_email_verify">Your password has been reset.</p>';
            }
        }
        ?>
        <p class="form__text">
            <a href="../forgotpassword/index.php" class="form__link" class="form__link">Forgot your password?</a>
        </p>
        <p class="form__text">
            <a class="form__link" href="#" id="linkHomepage">Go back to Homepage</a>
        </p>
    </form>

</div>

</body>