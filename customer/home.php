<?php 

require_once "../classes.php";
require_once "./components/navbar.php";
require_once "./components/footer.php";
require_once "./components/product-card.php";

session_start();

$products = Product::getAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Store</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <!-- Navbar -->
    <?php render_navbar(['active' => 'home']); ?>

    <!-- Hero -->
    <section class="page-hero text-white text-center" 
        style="background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('/images/background.jpg');"
        >
        <div class="container">
            <h1 class="display-4 fw-bold">Welcome to OnlineStore</h1>
            <p class="lead">Everything you need, delivered to your door</p>
            <a href="/customer/products.php" class="btn btn-warning btn-lg">Shop Now</a>
        </div>
    </section>
    
    <!-- Why Choose Us -->
    <section class="py-5">
        <div class="container text-center">
            <h2 class="mb-4">Why Choose OnlineStore?</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <h5>🚚 Fast Delivery</h5>
                    <p>Quick and safe shipping for all orders</p>
                </div>
                <div class="col-md-4">
                    <h5>💰 Best Prices</h5>
                    <p>Affordable products with great value</p>
                </div>
                <div class="col-md-4">
                    <h5>⭐ Trusted Quality</h5>
                    <p>Only high-quality and verified products</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Products -->
    <section class="bg-light py-5">
        <div class="container">
            <h2 class="text-center mb-4">Featured Products</h2>
            <div class="row g-4">

                <?php 
                $len = 4 > count($products) ? count($products) : 4;
                for ($i=0; $i < $len; $i++) {        
                    render_product_card($products, $i);
                } ?>

    
            </div>
        </div>
    </section>


    <!-- Offer -->
    <section class="bg-secondary text-white py-5 text-center">
            <div class="container">
                <h2>Special Offer!</h2>
                <p>Get up to 30% off on selected products</p>
                <a href="/customer/products.php" class="btn btn-warning">Shop Deals</a>
            </div>
        </section>
        
        <!-- Testimonials -->
        <section class="py-5">
            <div class="container text-center">
                <h2 class="mb-4">What Our Customers Say</h2>
                <div class="row g-4">
                    <div class="col-md-4">
                        <blockquote>"Great products and fast delivery!"</blockquote>
                        <p class="fw-bold">– Sarah</p>
                    </div>
                    <div class="col-md-4">
                        <blockquote>"Affordable prices and good quality."</blockquote>
                        <p class="fw-bold">– Ahmed</p>
                    </div>
                    <div class="col-md-4">
                        <blockquote>"Excellent customer service."</blockquote>
                        <p class="fw-bold">– John</p>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Newsletter -->
        <section class="bg-light py-5">
            <div class="container text-center">
                <h2>Subscribe to Our Newsletter</h2>
                <p>Get updates about new products and offers</p>
                <div class="row justify-content-center">
                    <div class="col-md-4">
                    </div>
                </div>
            </div>
        </section>
    </main>
    <!-- Footer -->
    <?php render_footer(); ?>
</body>
</html>