<?php

$br = "<br>";

spl_autoload_register(
    function ($class) {
        $filename = realpath(dirname(__FILE__));
        include_once $filename . "/../lib/" . $class . ".php";
    }
);

Session::init();

if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    Session::destroy();
}

$siteLink = (Session::get('login') == TRUE ? 'index.php' : 'login.php');



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>Login Registration System</title>
</head>

<body>
    <div id="main">
        <div class="container">
            <div class="row">
                <section class="header">
                    <div class="row">
                        <div class="box">
                            <h3><a href="<?php echo $siteLink; ?>">Login Registration System With OOP</a></h3>
                            <nav style="text-align: right;">

                                <?php
                                if (Session::get('login') == TRUE) {
                                ?>
                                <a href="index.php">Home</a>
                                <a href="profile.php">Profile</a>
                                <a href="change.php">Change</a>
                                <a href="upload.php">Upload</a>
                                <a href="mysqli.php">MySQLi</a>
                                <a href="?action=logout">Logout</a>
                                <?php } else { ?>
                                <a href="login.php">Login</a>
                                <a href="register.php">Register</a>
                                <?php } ?>
                            </nav>
                        </div>
                    </div>
                </section>
                <section class="content">
                    <div class="row">
                        <div class="min-height">