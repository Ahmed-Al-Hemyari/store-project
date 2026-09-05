<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

$error = "";
$email_error = "";

require "../database/connection.php";
require "../classes.php";

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    $user = User::checkEmailIfExist($email);
    if (!$user) {
        $email_error = "Email doesn't exist, please register first!";
    } else {
        $user = User::findByEmail($email);

        if (password_verify($password, $user->password)) {
            $_SESSION['user']['id'] = $user->id;
            $_SESSION['user']['name'] = $user->name;
            $_SESSION['user']['email'] = $user->email;
            $_SESSION['user']['phone'] = $user->phone;
            $_SESSION['user']['admin'] = (bool) $user->admin;

            header("Location: /");
            exit();
        } else {
            $error = "Incorrect password!";
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
    <title>Login</title>
</head>
<body>
    <main class="">
        <div class="card card-body min-w-9/12 max-w-110 mt-50 mx-auto">
            <h3 class="card-title mx-auto mb-20">Login</h3>
            <p class="mx-auto mt-20 text-gray-500">Login to access your orders</p>
            <?php if (!empty($error)): ?>
                <p class="mx-auto mt-10 text-red-500" id="form-error"><?= $error ?></p>
            <?php endif; ?>
            <form action="" method="post" class="mt-10 flex flex-column">                
                <label for="email" class="text-red-600 text-sm" id="email-error"><?= $email_error ?></label>
                <input type="email" name="email" required placeholder="Enter email..." 
                    class="w-full h-10 p-2 rounded-2 border-1 border-gray-300 mb-4">
                
                <input type="password" name="password" required placeholder="Enter password..." 
                    class="w-full h-10 p-2 rounded-2 border-1 border-gray-300 mb-4">
                    
                <p class="text-gray-700">Don't have an account? <a href="./register.php">Register</a></p>
                
                <button type="submit" class="btn btn-success">Login</button>
            </form>
        </div>
    </main>

    <script src="../css/tailwind.css"></script>
</body>
</html>

