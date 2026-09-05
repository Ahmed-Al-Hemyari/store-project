<?php

require_once "../classes.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderId = isset($_POST['order_id']) ? (int) $_POST['order_id'] : null;
    $order = $orderId ? Order::find($orderId) : null;

    if ($order) {
        $order->update(status: 'cancelled');
    }

    $referer = $_SERVER['HTTP_REFERER'] ?? '/customer/cart.php';
    header("Location: " . $referer);
    exit();
}