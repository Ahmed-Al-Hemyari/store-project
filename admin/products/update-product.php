<?php

require_once "../components/navbar.php";
require_once "../../classes.php";

session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['admin'] == false) {
    header("Location: /store-project/auth/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === "GET") {
    $productId = $_GET['id'];
}

$product = Product::find($productId);

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
    
    <pre>
    <?php 
        print_r($product);
    ?>
    </pre>
</body>
</html>