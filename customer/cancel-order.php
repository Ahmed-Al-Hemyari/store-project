<?php

require_once "../classes.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $orderId = isset($_GET['id']) ? (int) $_GET['id'] : null;
    $order = $orderId ? Order::find($orderId) : null;

    if ($order) {
        $order->update(status: 'cancelled');
    }

    $referer = $_SERVER['HTTP_REFERER'] ?? '/customer/cart.php';
    header("Location: " . $referer);
    exit();
}