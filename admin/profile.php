<?php

require_once "../classes.php";
require_once "./components/navbar.php";

session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['admin'] == false) {
    header("Location: /auth/login.php");
    exit();
}

$user = User::find($_SESSION['user']['id']) ?? null;
if (!$user) {
    unset($_SESSION['user']);
    header("Location: /auth/login.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <title>OnlineStore - Profile</title>
</head>
<body>
    <?php render_navbar(); ?>
    <pre>
        <?php 
            print_r($user);
        ?>
    </pre>
</body>
</html>