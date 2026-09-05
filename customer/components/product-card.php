<?php

function render_product_card(array $products, int $i) {
?>    
<div class="col-6 col-md-4 col-lg-3 mb-4">
    <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden product-card transition-all">
        <!-- Image Container with Aspect Ratio -->
        <div class="ratio ratio-4x3 bg-light overflow-hidden position-relative">
            <img 
                src="<?= htmlspecialchars($products[$i]->image ?? '/images/default.png'); ?>" 
                class="card-img-top object-fit-cover w-100 h-100" 
                alt="<?= htmlspecialchars($products[$i]->name); ?>" 
                loading="lazy"
            >
        </div>

        <!-- Card Body -->
        <div class="card-body d-flex flex-column justify-content-between p-3 text-center">
            <div>
                <h6 class="card-title text-truncate fw-semibold mb-2" title="<?= htmlspecialchars($products[$i]->name); ?>">
                    <?= htmlspecialchars($products[$i]->name); ?>
                </h6>
                <p class="card-text text-primary fs-5 fw-bold mb-3">
                    $<?= number_format($products[$i]->price, 2); ?>
                </p>
            </div>
            
            <a href="/customer/cart-action.php?action=add&id=<?= $products[$i]->id ?>" class="btn btn-outline-primary btn-sm rounded-pill w-100 fw-medium">
                Add to Cart
            </a>
        </div>
    </div>
</div>
<?php } ?>