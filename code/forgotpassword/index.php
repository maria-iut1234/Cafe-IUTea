<!DOCTYPE html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <title>Forgot Password</title>
    <link rel="shortcut icon" href="/assets/favicon.ico">
    <link rel="stylesheet" href="./src/main.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;600;700&display=swap" rel="stylesheet">
</head>

<?php

    $username = $email = $passError = $passError1 = $emailError = $userError = $password = $confirmPassword = '';
?>

<body>
    
    <div class="container">


        <!--Forgot Password form-->
        <form action="reset-request.inc.php" method="POST" class="form" id="forgotAccount">
            <h1 class="form__title">Forgot Password?</h1>
            <h6>An e-mail will be sent to you about resetting your password shortly.</h6>
            <div class="form__message form__message--error"></div>
            <div class="form__input-group">
                <input type="text" class="form__input" autofocus placeholder="Enter Your Email Address" name="email" required>
                <div class="form__input-error-message">
                    <?php echo $emailError ? $emailError : null; ?>
                </div>
            </div> 
            <button class="form__button" type="submit" name="reset-request-submit">Continue</button>
            <p class="form__text">
                <a class="form__link" href="../login/index.php" id="linkLogin">Remember account details? Sign in</a>
            </p>
        </form>
        <?php
        if(isset($_GET["reset"])){
            if($_GET["reset"]=="success"){
                echo'<p class="form__message form__message--error">Check your Email</p>';
            }else if($_GET["reset"]=="tokenExpired"){
                echo'<p class="form__message form__message--error">You need re-submit your reset request. The validation period is over.</p>';
            }else if($_GET["reset"]=="userdoesnotexist"){
                echo'<p class="form__message form__message--error">No user under that email exists in our Database.</p>';
            }else if($_GET["reset"]=="invalidemail"){
                echo'<p class="form__message form__message--error">The email you entered is Invalid.</p>';
            }else if($_GET["reset"]=="emptyrow"){
                echo'<p class="form__message form__message--error">No user under that email exists in our Database.</p>';
            }
            else if($_GET["reset"]=="tokenFail"){
                echo'<p class="form__message form__message--error">You need re-submit your reset request. Token Check Failed.</p>';
            }
        }
        ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <!-- <script src="./src/main.js"></script> -->
</body>
