<?php 

require_once "../classes.php";
require_once "../components/navbar.php";
session_start();

$products = Product::getAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Store - Products</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/bootstrap.css">
</head>
<body>
    <main>
        <!-- Navbar -->
        <?php render_navbar(['active' => 'products']); ?>

        <!-- Hero -->
        <section class="page-hero text-center" style="background: linear-gradient(rgba(0,0,0,.6), rgba(0,0,0,.6)), url('/images/background-products.jpg');">
            <h1 class="fw-bold">Our Products</h1>
            <p>Browse our best-selling items</p>
        </section>

        <!-- Products -->
        <section class="bg-light py-5" style="min-height: 100vh;">
            <div class="container">
                <div class="row g-4">

                    <?php 
                    $len = 4 > count($products) ? count($products) : 4;
                    for ($i=0; $i < $len; $i++) { ?>            
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
                                    
                                    <a href="products/phones.html" class="btn btn-outline-primary btn-sm rounded-pill w-100 fw-medium">
                                        Add to Cart
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php  } ?>

        
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-dark text-white pt-5 pb-3">
            <div class="container">
                <div class="row">
                    <!-- About -->
                    <div class="col-md-4 mb-4 text-start">
                        <h5 class="fw-bold">OnlineStore</h5>
                        <p class="text-white" style="font-size: 0.9rem;">
                            A modern e-commerce platform focused on quality, affordability, and customer satisfaction.
                        </p>
                    </div>

                    <!-- Quick Links -->
                    <div class="col-md-4 mb-4 text-center">
                        <h5 class="fw-bold">Quick Links</h5>
                        <ul class="list-unstyled">
                            <li><a href="/customer/home.php" class="text-white text-decoration-none">Home</a></li>
                            <li><a href="/customer/products.php" class="text-white text-decoration-none">Shop</a></li>
                            <li><a href="/customer/about.php" class="text-white text-decoration-none">About</a></li>
                            <li><a href="/customer/contact.php" class="text-white text-decoration-none">Contact</a></li>
                        </ul>
                    </div>

                    <!-- Contact Info -->
                    <div class="col-md-4 mb-4 text-start">
                        <h5 class="fw-bold">Contact</h5>
                        <p class="text-white mb-1">Email: support@onlinestore.com</p>
                        <p class="text-white mb-1">Phone: +123 456 789</p>
                        <p class="text-white">Address: Main Street, City</p>
                    </div>
                </div>

                <hr class="bg-secondary">

                <p class="mb-0 text-center text-white" style="font-size: 0.9rem;">
                    © 2026 OnlineStore. All rights reserved.
                </p>
            </div>
        </footer>
    </main>
</body>
</html>