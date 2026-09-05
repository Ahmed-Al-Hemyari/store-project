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
    <title>Online Store - Products</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/bootstrap.css">
</head>
<body>
    <main>
        <!-- Navbar -->
        <?php render_navbar(['active' => 'products']); ?>

        <!-- Hero -->
        <section class="page-hero text-center" style="background: linear-gradient(rgba(0,0,0,.6), rgba(0,0,0,.6)), url('/store-project/images/background-products.jpg');">
            <h1 class="fw-bold">Our Products</h1>
            <p>Browse our best-selling items</p>
        </section>

        <!-- Products -->
        <section class="bg-light py-5" style="min-height: 100vh;">
            <div class="container">
                <div class="row g-4">

                    <?php 
                    $len = 4 > count($products) ? count($products) : 4;
                    for ($i=0; $i < $len; $i++) {         
                        render_product_card($products, $i);
                    }
                    ?>
        
                </div>
            </div>
        </section>

        <!-- Footer -->
        <?php render_footer(); ?>
    </main>
</body>
</html>