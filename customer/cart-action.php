<?php

session_start();
require_once "../classes.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $action = $_GET['action'] ?? null;
    $productId = isset($_GET['id']) ? (int) $_GET['id'] : null;
    
    if ($productId && $action) {
        switch ($action) {
            case 'add':
                Cart::add($productId);
                break;
            case 'increase':
                Cart::increaseQuantity($productId);
                break;
            case 'decrease':
                Cart::decreaseQuantity($productId);
                break;
            case 'remove':
                Cart::remove($productId);
                break;
        }
    }
    
    $referer = $_SERVER['HTTP_REFERER'] ?? '/store-project/customer/cart.php';
    header("Location: " . $referer);
    exit();
}


