<?php

function render_navbar(array $props = []): void {
$activePage = $props['active'] ?? 'users';
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="/customer/home.php">OnlineStore</a>
        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="nav">
            <ul class="navbar-nav ms-auto d-flex gap-4">
                <li class="nav-item"><a class="nav-link <?= $activePage == 'users' ? 'active' : ''; ?>" href="/admin/users/users-table.php" id="users">Users</a></li>
                <li class="nav-item"><a class="nav-link <?= $activePage == 'products' ? 'active' : ''; ?>" href="/admin/products/products-table.php" id="products">Products</a></li>
                <li class="nav-item"><a class="btn btn-primary" href="/admin/profile.php">Profile</a></li>
            </ul>
        </div>
    </div>
</nav>

<?php 
    }
?>