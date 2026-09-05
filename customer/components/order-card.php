<?php

function render_order_card($order) { 
    $status = strtolower($order->status ?? 'pending');
    $statusClass = match($status) {
        'completed', 'delivered' => 'bg-success',
        'cancelled' => 'bg-danger',
        'processing' => 'bg-info text-dark',
        default => 'bg-warning text-dark'
    };

?>
<div class="accordion-item border rounded-3 mb-3 overflow-hidden shadow-sm">
    <h2 class="accordion-header" id="heading<?= $order->id; ?>">
        <button class="accordion-button collapsed bg-white py-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $order->id; ?>">
            <div class="d-flex justify-content-between align-items-center w-100 me-3">
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
            </div>
        </button>
    </h2>
    <div id="collapse<?= $order->id; ?>" class="accordion-collapse collapse" data-bs-parent="#ordersAccordion">
        <div class="accordion-body bg-light border-top">
            <h6 class="fw-semibold mb-3 small text-uppercase text-muted">Purchased Items</h6>
            
            <?php if (!empty($order->orderItems)): ?>
                <div class="list-group list-group-flush rounded-3 border mb-3">
                    <?php foreach ($order->orderItems as $item): ?>
                        <div class="list-group-item d-flex justify-content-between align-items-center bg-white p-3">
                            <div class="d-flex align-items-center">
                                <img 
                                    src="<?= htmlspecialchars($item->product->image ?? '/images/default.png'); ?>" 
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
                    <form action="/customer/cancel-order.php" method="POST" onsubmit="return confirm('Are you sure you want to cancel Order #<?= $order->id; ?>?');">
                        <input type="hidden" name="order_id" value="<?= $order->id; ?>">
                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                            Cancel Order
                        </button>
                    </form>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>
<?php } ?>