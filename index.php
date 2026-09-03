<?php
    session_start();

    // if (!isset($_SESSION['user_id'])) {
    //     header("Location: ./auth/login.php"); // Adjust path if needed
    //     exit();
    // }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <main>
        <nav class="navbar nav bg-gray-100">
            <a href="" class="text-decoration-none">
                <li class="nav-item nav-link active">
                    Home
                </li>
            </a>
            <a href="" class="text-decoration-none">
                <li class="nav-item nav-link">
                    Products
                </li>
            </a>
            <a href="" class="text-decoration-none">
                <li class="nav-item nav-link">
                    About
                </li>
            </a>
        </nav>

    </main>
    <p class="text-xl text-red-600">Welcome <?php echo $_SESSION['name'] ?></p>
    <script src="css/tailwind.css"></script>
</body>
</html>