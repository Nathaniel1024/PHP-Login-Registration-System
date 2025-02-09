<?php
require_once 'config/db.php';
require __DIR__ . '/vendor/phpmailer/phpmailer/src/Exception.php';
require __DIR__ . '/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require __DIR__ . '/vendor/phpmailer/phpmailer/src/SMTP.php';
$message = ""; // Initialize message variable

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['email'])) {
    $email = trim(filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL));

    // Check if user exists
    $checkUserQuery = "SELECT * FROM users WHERE email=?";
    $stmt = mysqli_prepare($db, $checkUserQuery);
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    

    if (mysqli_num_rows($result) > 0) {

        // First, delete any existing tokens for this email
        $deleteExistingTokenQuery = "DELETE FROM password_resets WHERE email = ?";
        $deleteStmt = mysqli_prepare($db, $deleteExistingTokenQuery);
        mysqli_stmt_bind_param($deleteStmt, 's', $email);
        mysqli_stmt_execute($deleteStmt);

        session_start();
        
        $token = bin2hex(random_bytes(50));
        $_SESSION['token'] = $token;
        $_SESSION['email'] = $email;
        $expires = date('Y-m-d H:i:s', strtotime('+30 minutes'));

        $sql = "INSERT INTO password_resets (email, token, expires) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($db, $sql);
        mysqli_stmt_bind_param($stmt, 'sss', $email, $token, $expires);
        mysqli_stmt_execute($stmt);

        $resetLink = "http://localhost/feifei/reset-password.php?token=" . urlencode($token);
        $subject = "Password Reset Request";
        $message = "Click the following link to reset your password: <a href=\"$resetLink\">Reset Password</a>";

        $mail = new PHPMailer(true);

        try {
            //Server settings
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'your username';                     //SMTP username
            $mail->Password   = 'your password';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;           //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
            //Recipients
            $mail->setFrom($email, 'Nathaniel Bot');
            $mail->addAddress($email);     //Add a recipient
    
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Reset Password Link';
            $mail->Body    = 'Hello '.$email.',<br>Click the link below to reset your password.<br><a href="'.$resetLink.'">Reset Password</a>';
    
            $mail->send();
            $message = 'Message has been sent, please check your email';
        } catch (Exception $e) {
            $message = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
        
    } else {
        $message = "User does not exist!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/dark.css">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="assets/Bearwon-Dark.png" type="image/x-icon">
    <title>Forgot Password</title>
</head>
<body>
    <form action="forgot-password.php" method="post">
        <h1>Forgot Password</h1>
        <label for="email">Email</label> <br>
        <input type="email" name="email" required> <br>
        <button type="submit" name="forgot-password">Reset Password</button>
        <br>
        <p>Remembered your password? <a href="index.php">Login</a></p>
        <p style="color: red; text-align:center;"><?php echo $message; ?></p> <!-- Display the login message here -->
    </form>
</body>
</html>


