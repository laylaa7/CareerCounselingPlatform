<?php
include_once "includes/DB.inc.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
?>


<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $VCode = $_POST["VCode"] ?? '';
    $VC = $_COOKIE['VCode'] ?? ''; // Get the verification code from the cookie
    $EmailUn = $_COOKIE['Emailforv'] ?? ''; // Email for verification

    if (isset($_POST['Submit'])) {
        if ($VC === $VCode) {
            echo "<script>alert('Mail Verified Successfully');</script>";
            // Redirect to password reset form
            header("Location: reset_password.php");
            exit();
        } else {
            echo "<script>alert('Invalid Verification Code');</script>";
        }
    }

    if (isset($_POST['resend_code'])) {
        $RVCode = bin2hex(random_bytes(3)); // Generate a new random code
        setcookie("VCode", $RVCode, time() + 1500); // Update cookie with the new code

        // Resend email logic using PHPMailer
        require 'vendor/autoload.php'; // Include PHPMailer
        
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->isSMTP();                                            
            $mail->Host = 'smtp.example.com';  
            $mail->SMTPAuth = true;                                   
            $mail->Username = 'your-email@example.com';                 
            $mail->Password = 'your-email-password';                          
            $mail->SMTPSecure = 'tls';                               
            $mail->Port = 587;                                       

            //Recipients
            $mail->setFrom('your-email@example.com', 'Your Website');
            $mail->addAddress($EmailUn);    

            //Content
            $mail->isHTML(true);                                  
            $mail->Subject = 'Password Reset Verification Code';
            $mail->Body    = 'Your new verification code is: ' . $RVCode;

            $mail->send();
            echo "<script>alert('Verification code resent to your email');</script>";
        } catch (Exception $e) {
            echo "<script>alert('Verification email could not be sent.');</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="css/verify.css">
    <title>Verify Mail</title>
</head>
<body>
<div class="container">

<h4>Verify Mail</h4>
<form action="" method="post">
    <label>Enter Your Verification Code:</label><br>
    <input type="text" name="VCode"><br>
    <input type="submit" value="Submit" name="Submit">
    <input type="submit" value="Re-Send Code" name="resend_code">
</form>
</div>
</body>