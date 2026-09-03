<?php

session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>OnlineStore - About</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <style>
        .card:hover {
            transform: translateY(-10px) scale(1.03);
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        }
        .py-8 {
            padding-top: 8rem !important;
            padding-bottom: 8rem !important;
        }
        .mb-6 {
            margin-bottom: 6rem !important;
        }
        .fs-1 {
            font-size: 3rem !important;
        }
    </style>
</head>
<body>
    <!-- Main -->
    <main>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="/customer/home.php">OnlineStore</a>
                <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="nav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="/customer/home.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="/customer/products.php">Products</a></li>
                        <li class="nav-item"><a class="nav-link active" href="/customer/about.php">About</a></li>
                        <li class="nav-item"><a class="nav-link" href="/customer/contact.php">Contact</a></li>

                        <?php if(isset($_SESSION['user'])) {?>
                            <li class="nav-item"><a class="btn btn-primary" href="/customer/profile.php">Profile</a></li>
                        <?php } else { ?>
                            <li class="nav-item"><a class="btn btn-primary" href="/auth/login.php">Login</a></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </nav>
        
        <section class="py-8 position-relative" style="background: linear-gradient(180deg, #f8f9fa 0%, #e9ecef 100%); min-height: 100vh;">
            <div class="container">
                <!-- Section Header -->
                <div class="text-center mb-6">
                    <h2 class="fw-bold display-4">About OnlineStore</h2>
                    <p class="text-secondary fs-5 mx-auto" style="max-width: 700px;">
                        OnlineStore is a modern e-commerce platform designed for simplicity, usability, and responsive shopping experience. 
                        Our goal is to make online shopping seamless and enjoyable for everyone.
                    </p>
                </div>

                <!-- Mission, Vision, Values Cards -->
                <div class="row g-5 justify-content-center text-center mb-6">
                    <div class="col-md-4">
                        <div class="card h-100 border-0 text-white p-5" style="background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%); transition: transform 0.3s;">
                            <div class="mb-3 fs-1">🎯</div>
                            <h5 class="fw-bold mb-3">Our Mission</h5>
                            <p>Provide quality products at affordable prices with a seamless shopping experience.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 border-0 text-white p-5" style="background: linear-gradient(135deg, #ff416c 0%, #ff4b2b 100%); transition: transform 0.3s;">
                            <div class="mb-3 fs-1">👁️</div>
                            <h5 class="fw-bold mb-3">Our Vision</h5>
                            <p>Become a trusted online shopping destination, known for reliability and innovation.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 border-0 text-white p-5" style="background: linear-gradient(135deg, #00c6ff 0%, #0072ff 100%); transition: transform 0.3s;">
                            <div class="mb-3 fs-1">❤️</div>
                            <h5 class="fw-bold mb-3">Our Values</h5>
                            <p>Trust, quality, and customer satisfaction guide everything we do.</p>
                        </div>
                    </div>
                </div>

                <!-- Why Choose Us / Extra Content -->
                <div class="text-center mt-6">
                    <h3 class="fw-bold mb-4">Why Choose OnlineStore? 🛒</h3>
                    <p class="text-secondary mx-auto" style="max-width: 700px;">
                        We combine quality, affordability, and a user-friendly experience to make online shopping simple and reliable. 
                        Our products are carefully curated and our support is always ready to help.
                    </p>
                </div>
            </div>
        </section>

    </main>
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
</body>
</html>
