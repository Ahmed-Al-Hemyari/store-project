<?php

require_once "./components/navbar.php";
require_once "../classes.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$cart = Cart::getItems();
$userId = $_SESSION['user']['id'] ?? null;
$user = $userId ? User::find((int) $userId) : null;

function submitOrder(): void {
    global $cart, $user;

    $order = Order::create($user->id);
    if (!$order) {
        header("Location: /customer/cart.php");
        exit();
    }

    $validProducts = true;

    foreach ($cart['items'] as $item) {

        $product = Product::find($item['product']->id);
        if (!$product) {
            $validProducts = false;
        }
    }

    if (!$validProducts) {
        $order->delete();
        header("Location: /customer/home.php");
        exit();
    }

    foreach ($cart['items'] as $item) {

        $product = Product::find($item['product']->id);
        OrderItem::create($order->id, $product->id, (int) $item['quantity']);
    }

    Cart::clear();
    header("Location: /customer/order-page.php?id=" . $order->id);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (!$user) {
        unset($_SESSION['user']);
        header("Location: /auth/login.php");
        exit();
    }

    if (empty($cart['items'])) {
        header("Location: /customer/cart.php");
        exit();
    }

    submitOrder();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <title>OnlineStore - Cart</title>
</head>
<body class="bg-light">
    <?php render_navbar(); ?>

    <div class="container my-5">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h2 class="fw-bold m-0">Shopping Cart</h2>
            <span class="badge bg-primary rounded-pill fs-6"><?= $cart['totalQuantity'] ?? 0; ?> Items</span>
        </div>

        <?php if (empty($cart['items'])) { ?>
            <div class="card border-0 shadow-sm p-5 text-center my-4">
                <h4 class="fw-semibold">Your cart is empty</h4>
                <p class="text-muted mb-4">Looks like you haven't added anything to your cart yet.</p>
                <div>
                    <a href="/customer/products.php" class="btn btn-primary px-4 rounded-pill">Continue Shopping</a>
                </div>
            </div>
        <?php } else { ?>
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col" class="ps-4">Product</th>
                                        <th scope="col">Price</th>
                                        <th scope="col" class="text-center">Quantity</th>
                                        <th scope="col">Subtotal</th>
                                        <th scope="col" class="text-end pe-4">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($cart['items'] as $item) { ?>
                                        <tr>
                                            <td class="ps-4">
                                                <div class="d-flex align-items-center">
                                                    <img 
                                                        src="<?= htmlspecialchars($item['product']->image ?? '/images/default.png'); ?>" 
                                                        alt="<?= htmlspecialchars($item['product']->name); ?>" 
                                                        class="rounded border object-fit-cover me-3"
                                                        style="width: 60px; height: 60px;"
                                                    >
                                                    <div>
                                                        <h6 class="mb-0 fw-semibold text-truncate" style="max-width: 200px;">
                                                            <?= htmlspecialchars($item['product']->name); ?>
                                                        </h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="fw-medium">
                                                $<?= number_format($item['product']->price, 2); ?>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center justify-content-center">
                                                    <a href="/customer/cart-action.php?action=decrease&id=<?= $item['product']->id; ?>" class="btn btn-sm btn-outline-secondary rounded-circle px-2 py-0 fw-bold">-</a>
                                                    <span class="mx-3 fw-bold"><?= $item['quantity']; ?></span>
                                                    <a href="/customer/cart-action.php?action=increase&id=<?= $item['product']->id; ?>" class="btn btn-sm btn-outline-secondary rounded-circle px-2 py-0 fw-bold">+</a>
                                                </div>
                                            </td>
                                            <td class="fw-bold text-primary">
                                                $<?= number_format($item['subtotal'], 2); ?>
                                            </td>
                                            <td class="text-end pe-4">
                                                <a href="/customer/cart-action.php?action=remove&id=<?= $item['product']->id; ?>" class="btn btn-sm btn-outline-gray border-0" title="Remove item">
                                                    🗑️
                                                </a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm rounded-3 p-4">
                        <h5 class="fw-bold mb-3">Order Summary</h5>
                        <div class="d-flex justify-content-between mb-2 text-muted">
                            <span>Subtotal</span>
                            <span>$<?= number_format($cart['grandTotal'], 2); ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-3 text-muted">
                            <span>Shipping</span>
                            <span class="text-success fw-medium">Free</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-4">
                            <span class="fw-bold fs-5">Total</span>
                            <span class="fw-bold fs-5 text-primary">$<?= number_format($cart['grandTotal'], 2); ?></span>
                        </div>
                        <form action="" method="post">
                            <button type="submit" class="btn btn-primary w-100 py-2 rounded-pill fw-semibold">
                                Submit Order
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</body>
</html>