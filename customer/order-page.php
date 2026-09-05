<?php

require_once "../classes.php";
require_once "./components/navbar.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$orderId = isset($_GET['id']) ? (int)$_GET['id'] : null;
$order = $orderId ? Order::find($orderId) : null;

// Security & Verification Checks
$sessionUserId = $_SESSION['user']['id'] ?? null;

if (!$sessionUserId) {
    header('Location: /auth/login.php');
    exit();
}

if ($order && (int)$order->user_id !== (int)$sessionUserId) {
    header('Location: /customer/home.php');
    exit();
}

// Status badge styling logic
$status = strtolower($order->status ?? 'pending');
$statusBadgeClass = match($status) {
    'completed' => 'bg-success',
    'cancelled' => 'bg-danger',
    'processing' => 'bg-info text-dark',
    default => 'bg-warning text-dark'
};

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OnlineStore - Order #<?= $order ? $order->id : 'Details'; ?></title>
    <link rel="stylesheet" href="../css/bootstrap.css">
</head>
<body class="bg-light">
    <?php render_navbar(); ?>

    <div class="container my-5">
        <?php if ($order) { ?>
            <!-- Order Header Banner -->
            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-body p-4 d-flex flex-wrap align-items-center justify-content-between gap-3">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <h3 class="fw-bold m-0">Order #<?= $order->id; ?></h3>
                            <span class="badge <?= $statusBadgeClass; ?> rounded-pill px-3 py-2 text-capitalize fs-6">
                                <?= htmlspecialchars($order->status ?? 'Pending'); ?>
                            </span>
                        </div>
                        <p class="text-muted m-0 small">Thank you for your purchase!</p>
                    </div>
                    <div>
                        <a href="/customer/profile.php" class="btn btn-outline-secondary rounded-pill px-4 me-2">
                            My Orders
                        </a>
                        <button onclick="window.print();" class="btn btn-primary rounded-pill px-4">
                            Print Receipt
                        </button>
                        <a href="/customer/cancel-order.php?id=<?= $order->id ?>" class="btn btn-outline-danger rounded-pill px-4 me-2">
                            Cancel
                        </a>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <!-- Order Items List -->
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                        <div class="card-header bg-white py-3 border-0">
                            <h5 class="fw-bold m-0">Order Items (<?= $order->itemsCount ?? count($order->orderItems); ?>)</h5>
                        </div>
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col" class="ps-4">Product</th>
                                        <th scope="col">Price</th>
                                        <th scope="col" class="text-center">Quantity</th>
                                        <th scope="col" class="text-end pe-4">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($order->orderItems)) { ?>
                                        <?php foreach ($order->orderItems as $item) { ?>
                                            <tr>
                                                <td class="ps-4">
                                                    <div class="d-flex align-items-center">
                                                        <img 
                                                            src="<?= htmlspecialchars($item->product->image ?? '/images/default.png'); ?>" 
                                                            alt="<?= htmlspecialchars($item->product->name ?? 'Product'); ?>" 
                                                            class="rounded border object-fit-cover me-3"
                                                            style="width: 50px; height: 50px;"
                                                        >
                                                        <div>
                                                            <h6 class="mb-0 fw-semibold text-truncate" style="max-width: 200px;">
                                                                <?= htmlspecialchars($item->product->name ?? 'Product'); ?>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="fw-medium">
                                                    $<?= number_format($item->product->price ?? 0, 2); ?>
                                                </td>
                                                <td class="text-center fw-bold">
                                                    <?= $item->quantity; ?>
                                                </td>
                                                <td class="text-end pe-4 fw-bold text-primary">
                                                    $<?= number_format(($item->product->price ?? 0) * $item->quantity, 2); ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <tr>
                                            <td colspan="4" class="text-center text-muted py-4">No items attached to this order.</td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Order Summary Sidebar -->
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm rounded-3 p-4">
                        <h5 class="fw-bold mb-3">Order Details</h5>
                        <div class="d-flex justify-content-between mb-2 text-muted">
                            <span>Customer Name</span>
                            <span class="fw-medium text-dark"><?= htmlspecialchars($order->user->name ?? 'Customer'); ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-2 text-muted">
                            <span>Email</span>
                            <span class="fw-medium text-dark"><?= htmlspecialchars($order->user->email ?? 'N/A'); ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-3 text-muted">
                            <span>Shipping</span>
                            <span class="text-success fw-medium">Free</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-0">
                            <span class="fw-bold fs-5">Total Paid</span>
                            <span class="fw-bold fs-5 text-primary">$<?= number_format($order->totalPrice ?? 0, 2); ?></span>
                        </div>
                    </div>
                </div>
            </div>

        <?php } else { ?>
            <!-- Fallback View: Invalid Order ID -->
            <div class="card border-0 shadow-sm p-5 text-center my-5 mx-auto" style="max-width: 500px;">
                <div class="mb-3 text-warning">
                </div>
                <h4 class="fw-semibold">Order Not Found</h4>
                <p class="text-muted mb-4">Please verify the URL parameters or select an order from your account history.</p>
                <div>
                    <a href="/customer/home.php" class="btn btn-primary px-4 rounded-pill">Return Home</a>
                </div>
            </div>
        <?php } ?>
    </div>

    <script src="../css/bootstrap.min.js"></script>
</body>
</html>