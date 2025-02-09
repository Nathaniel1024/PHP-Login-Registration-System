<?php
    require_once 'config/db.php';
    $message = ""; // Initialize message variable

    if (isset($_POST['login'])) {
        // Start the session
        session_start();
        
        // Sanitize and filter input
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);

        // Escape the input for database query
        $email = mysqli_real_escape_string($db, $email);
        $password = mysqli_real_escape_string($db, $password);

        // Check if the user exists in the database
        $sql = "SELECT * FROM users WHERE email='$email' LIMIT 1";
        $result = mysqli_query($db, $sql);

        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);

            // Verify the password
            if (password_verify($password, $user['password'])) {
                $_SESSION['user'] = $user['name'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['password'] = $user['password'];
                header("Location: welcome.php");
                exit();
            } else {
                $message = "Invalid password";
            }
        } else {
            $message = "User not found";
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
    <title>Login & Register</title>
</head>
<body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
        <h1>Login</h1>
        <label for="email">Email</label>
        <input type="email" name="email" required>
        <label for="password">Password</label>
        <input type="password" name="password" required>
        <a href="forgot-password.php">Forgot Password</a> <br> <br>
        <button type="submit" name="login">Login</button>
        <a href="register.php" style="text-decoration: none;">
            <button type="button" name="register">Register</button>
        </a>
        <p style="color: red; text-align:center;"><?php echo $message; ?></p> <!-- Display the login message here -->
    </form>
</body>
</html>
