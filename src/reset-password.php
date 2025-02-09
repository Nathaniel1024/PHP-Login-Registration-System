<?php
$message = ""; // Initialize message variable

if (isset($_GET['token'])) {
    require_once 'config/db.php';

    $token = $_GET['token'];

    // Verify the token
    $sql = "SELECT * FROM password_resets WHERE token=?";
    $stmt = mysqli_prepare($db, $sql);
    mysqli_stmt_bind_param($stmt, 's', $token);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 0) {
        $message = "Invalid token.";
    } else {
        $row = mysqli_fetch_assoc($result);
        $email = $row['email'];
    }
} else {
    $message = "No token provided!";
}

// Handle password reset submission
if (isset($_POST['reset-password'])) {
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    if ($password !== $confirm_password) {
        $message = "Passwords do not match!";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "UPDATE users SET password=? WHERE email=?";
        $stmt = mysqli_prepare($db, $sql);
        mysqli_stmt_bind_param($stmt, 'ss', $hashed_password, $email);
        mysqli_stmt_execute($stmt);

        // Clear the password reset token
        $sql = "DELETE FROM password_resets WHERE email=?";
        $stmt = mysqli_prepare($db, $sql);
        mysqli_stmt_bind_param($stmt, 's', $email);
        mysqli_stmt_execute($stmt);

        $message = "Password reset successful. Redirecting to the homepage...";
        header("refresh:3;url=index.php");
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
    <title>Reset Password</title>
</head>
<body>
    <form action="reset-password.php?token=<?php echo htmlspecialchars($token); ?>" method="post">
        <h1>Reset Password</h1>
        <label for="password">New Password</label> <br>
        <input type="password" name="password" required> <br>
        <label for="confirm_password">Confirm Password</label> <br>
        <input type="password" name="confirm_password" required> <br>
        <button type="submit" name="reset-password">Reset Password</button>
        <p style="color: red; text-align:center;"><?php echo $message; ?></p> <!-- Display message here -->
    </form>
</body>
</html>
