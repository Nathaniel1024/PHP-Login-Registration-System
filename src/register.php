<?php
    require_once 'config/db.php';
    $message = ""; // Initialize message variable

    if(isset($_POST['register'])){
        $username = mysqli_real_escape_string($db, trim($_POST['username']));
        $email = mysqli_real_escape_string($db, trim($_POST['email']));
        $password = mysqli_real_escape_string($db, trim($_POST['password']));

        // Check if user already exists
        $checkUserQuery = "SELECT * FROM users WHERE email='$email' LIMIT 1";
        $result = mysqli_query($db, $checkUserQuery);
        
        if(mysqli_num_rows($result) > 0){
            $message = "User already exists with this email.";
        } else {
            // Hash the password before storing
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO users (name, email, password) VALUES ('$username', '$email', '$hashedPassword')";

            if(mysqli_query($db, $sql)){
                header("Location: index.php");
                exit();
            } else {
                $message = "Error: " . $sql . "<br>" . mysqli_error($db);
            }
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
    <title>Register</title>
</head>
<body>
    <form action="register.php" method="post">
        <h1>Register</h1>
        <!-- Name -->
        <label for="username">Name</label>
        <input type="text" name="username" required>
        <!-- Email -->
        <label for="username">Email</label>
        <input type="email" name="email" required>
        <!-- Password -->
        <label for="password">Password</label>
        <input type="password" name="password" id="password" required>
        <!-- Register Button -->
        <button type="submit" name="register">Register</button>
        <!-- Message -->
        <p>Already have an account? <a href="index.php">Login</a></p>
        <p style="color: red; text-align:center;"><?php echo $message; ?></p> <!-- Display the login message here -->
    </form>
</body>
</html>
