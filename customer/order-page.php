<?php

require_once "../classes.php";
require_once "../components/navbar.php";

session_start();

if ($_SERVER['REQUEST_METHOD'] === "GET") {
    $orderId = $_GET['id'] ?? null;
}

$order = $orderId ? Order::find($orderId) : null;

if ($order->user->id !== $_SESSION['user']['id']) {
    header('Location: /index.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OnlineStore - Order Page</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
</head>
<body>
    <?php render_navbar(); ?>

    <?php if($order) { ?>
    <pre>
        <?php print_r($order); ?>
    </pre>
    <?php } else { ?>
    <div class="alert alert-warning text-center my-5" role="alert">
            <h4>Order Not Found</h4>
            <p>Please check the URL parameter or select a valid order.</p>
            <a href="/customer/home.php" class="btn btn-primary mt-2">Return Home</a>
        </div>
    <?php } ?>
</body>
</html>