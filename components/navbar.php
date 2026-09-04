<?php

function render_navbar(array $props = []): void {
$activePage = $props['active'] ?? '';
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="/customer/home.php">OnlineStore</a>
        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="nav">
            <ul class="navbar-nav ms-auto d-flex gap-4">
                <li class="nav-item"><a class="nav-link <?= $activePage == 'home' ? 'active' : ''; ?>" href="/customer/home.php" id="home">Home</a></li>
                <li class="nav-item"><a class="nav-link <?= $activePage == 'products' ? 'active' : ''; ?>" href="/customer/products.php" id="products">Products</a></li>
                <li class="nav-item"><a class="nav-link <?= $activePage == 'about' ? 'active' : ''; ?>" href="/customer/about.php" id="about">About</a></li>
                <li class="nav-item"><a class="nav-link <?= $activePage == 'contact' ? 'active' : ''; ?>" href="/customer/contact.php" id="contact">Contact</a></li>

                    <?php if(isset($_SESSION['user'])) {?>
                        <li class="nav-item"><a class="btn btn-primary" href="/customer/profile.php">Profile</a></li>
                    <?php } else { ?>
                        <li class="nav-item"><a class="btn btn-primary" href="/auth/login.php">Login</a></li>
                    <?php } ?>
                    
                    <li class="nav-item"><a class="btn btn-success" href="/customer/cart.php">Cart</a></li>
            </ul>
        </div>
    </div>
</nav>

<?php 
    }
?>