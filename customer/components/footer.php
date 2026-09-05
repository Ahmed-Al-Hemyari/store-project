<?php

function render_footer(): void {
?>
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
<?php } ?>