<?php

require_once "../components/navbar.php";
require_once "../../classes.php";

session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['admin'] == false) {
    header("Location: /auth/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === "GET") {
    $userId = $_GET['id'];
}

$user = User::find($userId);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/bootstrap.css">
    <title>Online Store - Users Table</title>
</head>
<body>
    <?php render_navbar(['active' => 'users']); ?>
    
    <pre>
    <?php 
        print_r($user);
    ?>
    </pre>
</body>
</html>