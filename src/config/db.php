<?php
    define('DB_SERVER', 'localhost');
    define('DB_USERNAME', 'your username');
    define('DB_PASSWORD', 'your password');
    define('DB_DATABASE', 'database name');

    $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);

    if(!$db){
        die("Connection failed: " . mysqli_connect_error());
        echo "Connection failed: " . mysqli_connect_error();
    }
?>