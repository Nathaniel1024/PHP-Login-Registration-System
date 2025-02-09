<?php
    session_start();

    $name = $_SESSION['user'];
    $email = $_SESSION['email'];
    $password = $_SESSION['password'];
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
        <h1>Welcome</h1>
        <h1>Name: <?php echo htmlspecialchars($name) ?></h1>
        <h1>Email: <?php echo htmlspecialchars($email) ?></h1>
        <input type="submit" name="logout" value="Logout">
        
    </form>
</body>
</html>

<?php
    require_once 'config/db.php';

    if (isset($_POST['logout'])) {
        session_destroy();
        header("Location: index.php");
    }
?>