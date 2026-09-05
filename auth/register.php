<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

$error = "";
$email_error = "";

require "../database/connection.php";
require_once "../classes.php";

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $name = htmlspecialchars(trim($_POST['name'] ?? ''));
    $email = htmlspecialchars(trim($_POST['email'] ?? ''));
    $phone = htmlspecialchars(trim($_POST['phone'] ?? ''));
    $password = htmlspecialchars(trim($_POST['password'] ?? ''));

    if (User::checkEmailIfExist($email)) {
        $email_error = "Email is already used!";
    } else {
        $user = User::create($name, $email, $phone, $password);
    
        if ($user) {
            header("Location: /store-project/auth/login.php");
            exit();
        } else {
            $error = "Error creating account!";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <title>Register</title>
</head>
<body>
    <main class="">
        <div class="card card-body min-w-9/12 max-w-110 mt-50 mx-auto">
            <h3 class="card-title mx-auto mb-20">Register</h3>
            <p class="mx-auto mt-20 text-gray-500">Enter your information to create your account</p>
            <?php if (!empty($error)): ?>
                <p class="mx-auto mt-10 text-red-500" id="form-error"><?= $error ?></p>
            <?php endif; ?>
            <form action="" method="post" class="mt-10 flex flex-column">

                <input type="text" name="name" required placeholder="Enter name..." 
                    class="w-full h-10 p-2 rounded-2 border-1 border-gray-300 mb-4">
                
                <label for="email" class="text-red-600 text-sm" id="email-error"><?= $email_error ?></label>
                <input type="email" name="email" required placeholder="Enter email..." 
                    class="w-full h-10 p-2 rounded-2 border-1 border-gray-300 mb-4">
                
                <input type="text" name="phone" placeholder="Enter phone..." 
                    class="w-full h-10 p-2 rounded-2 border-1 border-gray-300 mb-4">
                
                <input type="password" name="password" required placeholder="Enter password..." 
                    class="w-full h-10 p-2 rounded-2 border-1 border-gray-300 mb-4">
                    
                <p class="text-gray-700">Already have an account? <a href="./login.php">Login</a></p>
                
                <button type="submit" class="btn btn-success">Register</button>
            </form>
        </div>
    </main>

    <script src="../css/tailwind.css"></script>
</body>
</html>

