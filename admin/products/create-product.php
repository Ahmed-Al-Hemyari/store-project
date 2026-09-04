<?php

require_once "../components/navbar.php";
require_once "../../classes.php";

if (!isset($_SESSION['user']) || $_SESSION['user']['admin'] == false) {
    header("Location: /auth/login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/bootstrap.css">
    <title>Online Store - Products Table</title>
</head>
<body>
    <?php render_navbar(['active' => 'products']); ?>
</body>
</html>