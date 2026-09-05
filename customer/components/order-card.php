<?php

function render_order_card($order) { 
    $status = strtolower($order->status ?? 'pending');
    $statusClass = match($status) {
        'completed' => 'bg-success',
        'cancelled' => 'bg-danger',
        'processing' => 'bg-info text-dark',
        default => 'bg-warning text-dark'
    };
?>
<div class="accordion-item border rounded-3 mb-3 overflow-hidden shadow-sm">
    <div class="d-flex align-items-center bg-white py-3 px-3 border-bottom-0">
        <!-- Main Card Body: Navigates to order details page -->
        <a href="/store-project/customer/order-page.php?id=<?= $order->id; ?>" class="text-decoration-none d-flex justify-content-between align-items-center flex-grow-1 me-3">
            <div>
                <span class="fw-bold text-dark me-2">Order #<?= $order->id; ?></span>
                <span class="badge <?= $statusClass; ?> rounded-pill px-2 py-1 text-capitalize">
                    <?= htmlspecialchars($order->status ?? 'Pending'); ?>
                </span>
            </div>
            <div class="text-end">
                <span class="fw-bold text-primary">$<?= number_format($order->totalPrice ?? 0, 2); ?></span>
                <small class="text-muted d-block fs-7"><?= $order->itemsCount ?? count($order->orderItems ?? []); ?> item(s)</small>
            </div>
        </a>

        <!-- Toggle Arrow: Expands accordion dropdown -->
        <button class="btn btn-link p-0 text-muted shadow-none accordion-button collapsed flex-grow-0" 
                type="button" 
                data-bs-toggle="collapse" 
                data-bs-target="#collapse<?= $order->id; ?>" 
                aria-expanded="false" 
                aria-controls="collapse<?= $order->id; ?>"
                style="width: auto;">
        </button>
    </div>

    <div id="collapse<?= $order->id; ?>" class="accordion-collapse collapse" data-bs-parent="#ordersAccordion">
        <div class="accordion-body bg-light border-top">
            <h6 class="fw-semibold mb-3 small text-uppercase text-muted">Purchased Items</h6>
            
            <?php if (!empty($order->orderItems)): ?>
                <div class="list-group list-group-flush rounded-3 border mb-3">
                    <?php foreach ($order->orderItems as $item): ?>
                        <div class="list-group-item d-flex justify-content-between align-items-center bg-white p-3">
                            <div class="d-flex align-items-center">
                                <img 
                                    src="<?= htmlspecialchars($item->product->image ?? '/store-project/images/default.png'); ?>" 
                                    alt="<?= htmlspecialchars($item->product->name ?? 'Product'); ?>" 
                                    class="rounded border object-fit-cover me-3"
                                    style="width: 50px; height: 50px;"
                                >
                                <div>
                                    <h6 class="mb-0 fw-semibold fs-6">
                                        <?= htmlspecialchars($item->product->name ?? 'Unknown Product'); ?>
                                    </h6>
                                    <small class="text-muted">
                                        $<?= number_format($item->product->price ?? 0, 2); ?> × <?= $item->quantity; ?>
                                    </small>
                                </div>
                            </div>
                            <span class="fw-bold text-dark">
                                $<?= number_format(($item->product->price ?? 0) * $item->quantity, 2); ?>
                            </span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="text-muted small mb-3">No item details available for this order.</p>
            <?php endif; ?>

            <!-- Cancel Order Action -->
            <?php if (in_array($status, ['pending'])): ?>
                <div class="d-flex justify-content-end border-top pt-3">
                    <a href="/store-project/customer/cancel-order.php?id=<?= $order->id ?>" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                        Cancel Order
                    </a>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>
<?php } ?>