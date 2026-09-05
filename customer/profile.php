<?php

require_once "../classes.php";
require_once "./components/navbar.php";
require_once "./components/order-card.php";

session_start();

if (!isset($_SESSION['user'])) {
    header("Location: /auth/login.php");
    exit();
}

$user = User::find($_SESSION['user']['id']) ?? null;
if (!$user) {
    unset($_SESSION['user']);
    header("Location: /auth/login.php");
    exit();
}

$orders = Order::getUserOrders();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <title>OnlineStore - Profile</title>
</head>
<body class="bg-light">
    <?php render_navbar(['active' => 'profile']); ?>

    <div class="container my-5">
        <div class="row g-4">
            
            <!-- Left Column: User Profile Details -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                    <div class="bg-primary p-4 text-center text-white">
                        <div class="rounded-circle bg-white text-primary d-inline-flex align-items-center justify-content-center mb-3 shadow-sm" style="width: 80px; height: 80px; font-size: 32px; font-weight: bold;">
                            <?= strtoupper(substr($user->name ?? 'U', 0, 1)); ?>
                        </div>
                        <h5 class="mb-1 fw-bold"><?= htmlspecialchars($user->name); ?></h5>
                        <span class="badge bg-light text-dark fw-normal px-3 py-1 rounded-pill">
                            <?= $user->admin ? 'Administrator' : 'Customer'; ?>
                        </span>
                    </div>
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="text-uppercase text-muted fw-bold m-0 fs-7" style="letter-spacing: 0.5px;">Account Information</h6>
                            <a href="/customer/edit-profile.php" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                Edit
                            </a>
                        </div>
                        
                        <div class="mb-3">
                            <label class="small text-muted d-block">Full Name</label>
                            <span class="fw-semibold text-dark"><?= htmlspecialchars($user->name); ?></span>
                        </div>
                        
                        <div class="mb-3">
                            <label class="small text-muted d-block">Email Address</label>
                            <span class="fw-semibold text-dark"><?= htmlspecialchars($user->email); ?></span>
                        </div>

                        <div class="mb-0">
                            <label class="small text-muted d-block">Phone Number</label>
                            <span class="fw-semibold text-dark"><?= htmlspecialchars(empty($user->phone) ? 'Not provided' : $user->phone); ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Order History -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-3 p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="fw-bold m-0">My Orders</h5>
                        <span class="badge bg-secondary rounded-pill fs-6"><?= count($orders); ?> Orders</span>
                    </div>

                    <?php if (empty($orders)): ?>
                        <div class="text-center py-5">
                            <div class="mb-3 text-muted">
                            </div>
                            <h6 class="fw-semibold">No orders placed yet</h6>
                            <p class="text-muted small mb-3">When you purchase products, your history will appear here.</p>
                            <a href="/customer/products.php" class="btn btn-sm btn-primary rounded-pill px-4">Start Shopping</a>
                        </div>
                    <?php else: ?>
                        <div class="accordion accordion-flush" id="ordersAccordion">
                            <?php foreach ($orders as $index => $order):
                                render_order_card($order);
                            endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>

    <script src="../css/bootstrap.min.js"></script>
</body>
</html>