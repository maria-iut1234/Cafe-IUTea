<?php
    include "../dbconnect.php";
    session_start();
?>
<?php
include "testMail.php";


if(isset($_POST["reset-request-submit"])){
    $email = $_POST['email'];
    if(!filter_var($email, FILTER_VALIDATE_EMAIL))
        $emailError = "Invalid Email";
    if(empty($emailError))
    {
        if($conn -> connect_error){
            die('Connection Failed : ' .$conn->connect_error);
        }
        else{
            $sql ="SELECT * FROM employee WHERE e_email = ? LIMIT 1";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt,$sql)){
                echo "There was an error 6";
                exit();
            }
            else{
                mysqli_stmt_bind_param($stmt,"s",$email);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                if(!$row=mysqli_fetch_assoc($result)){
                    header("location: index.php?reset=emptyrow");
                    exit();
                }
            }
        }
    }
    else{
        header("location: index.php?reset=invalidemail");
        exit();
    }
$selector = bin2hex(random_bytes(8));
$token = random_bytes(32);
$binToken = bin2hex($token);
$url = "http://localhost:3000/code/forgotpassword/create-new-password.php?newpassword=nothing&selector=". urlencode($selector) . "&validator=" . urlencode($binToken);
$expires = date("U")+300;

if(!$conn){
    die("Connection Failed: ".mysqli_connect_error());
}

$userEmail = $_POST["email"];
$sql = "DELETE FROM passwordreset WHERE passwordResetEmail=?";
$stmt = mysqli_stmt_init($conn);
if(!mysqli_stmt_prepare($stmt,$sql)){
echo "There was an error deleting reset token";
exit();
}
else{
    mysqli_stmt_bind_param($stmt,"s",$userEmail);
    mysqli_stmt_execute($stmt);
}
$sql = "INSERT INTO passwordreset(passwordResetEmail,passwordResetSelector,passwordResetToken,passwordResetExpires) VALUES (?,?,?,?);";
$stmt = mysqli_stmt_init($conn);
if(!mysqli_stmt_prepare($stmt,$sql)){
echo "There was an error inserting reset tokens";
exit();
}
else{
    $hashedToken = password_hash($token,PASSWORD_DEFAULT);
    mysqli_stmt_bind_param($stmt,"ssss",$userEmail, $selector, $hashedToken, $expires);
    mysqli_stmt_execute($stmt);
}
mysqli_stmt_close($stmt);
mysqli_close($conn);

$to = $userEmail;
$subject = 'Reset your password';
$message = '<p>We recieved a password reset request. The link to reset your password is given below. If you did not make this request, you can ignore this email</p>';
$message .= '<p>Here is your password reset link: </br>';
$message .='<a href="'.$url.'">'.$url.'</a?></p>';

if(send_mail($to,$subject,$message))
{
    echo"Message sent";
}
else{
    echo"Message not sent";
}
header("location: ./index.php?reset=success");

}
else{
    header("location: ../login/index.php");
}

?>