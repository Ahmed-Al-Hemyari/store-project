<?php

require_once "../classes.php";
require_once "./components/navbar.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user'])) {
    header("Location: /auth/login.php");
    exit();
}

$user = User::find($_SESSION['user']['id']) ?? null;
if (!$user) {
    unset($_SESSION['user']);
    header("Location: /auth/login.php");
    exit();
}

$errors = [];
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');

    $currentPassword = $_POST['current_password'] ?? '';
    $newPassword     = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    if (empty($name)) {
        $errors[] = "Name is required.";
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "A valid email address is required.";
    }

    if (!empty($newPassword)) {
        if (empty($currentPassword)) {
            $errors[] = "Current password is required to set a new password.";
        } elseif (strlen($newPassword) < 6) {
            $errors[] = "New password must be at least 6 characters long.";
        } elseif ($newPassword !== $confirmPassword) {
            $errors[] = "New password and confirmation do not match.";
        }
    }

    if (empty($errors)) {
        $user->name  = $name;
        $user->email = $email;
        $user->phone = $phone;
        
        $updated = $user->update($name, $email, $phone, $currentPassword, $newPassword); 

        if ($updated) {
            $_SESSION['user']['name']  = $user->name;
            $_SESSION['user']['email'] = $user->email;

            $successMessage = "Profile updated successfully!";
        } else {
            $errors[] = "Failed to update profile. Please try again.";
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
    <title>OnlineStore - Edit Profile</title>
</head>
<body class="bg-light">
    <?php render_navbar(['active' => 'profile']); ?>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="fw-bold m-0">Edit Profile</h2>
                    <a href="/customer/profile.php" class="btn btn-outline-secondary rounded-pill px-4">
                        &larr; Back to Profile
                    </a>
                </div>

                <?php if (!empty($successMessage)): ?>
                    <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
                        <?= htmlspecialchars($successMessage); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger rounded-3 mb-4" role="alert">
                        <ul class="mb-0 ps-3">
                            <?php foreach ($errors as $error): ?>
                                <li><?= htmlspecialchars($error); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <!-- Edit Profile Form -->
                <div class="card border-0 shadow-sm rounded-3 p-4 p-md-5">
                    <form action="" method="POST">

                        <h5 class="fw-bold text-primary mb-3">Personal Information</h5>
                        
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">Full Name</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                id="name" 
                                name="name" 
                                value="<?= htmlspecialchars($_POST['name'] ?? $user->name ?? ''); ?>" 
                                required
                            >
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="email" class="form-label fw-semibold">Email Address</label>
                                <input 
                                    type="email" 
                                    class="form-control" 
                                    id="email" 
                                    name="email" 
                                    value="<?= htmlspecialchars($_POST['email'] ?? $user->email ?? ''); ?>" 
                                    required
                                >
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label fw-semibold">Phone Number</label>
                                <input 
                                    type="tel" 
                                    class="form-control" 
                                    id="phone" 
                                    name="phone" 
                                    placeholder="e.g. +123456789"
                                    value="<?= htmlspecialchars($_POST['phone'] ?? $user->phone ?? ''); ?>"
                                >
                            </div>
                        </div>

                        <hr class="my-4">

                        <h5 class="fw-bold text-primary mb-2">Change Password</h5>
                        <p class="text-muted small mb-3">Leave these fields blank if you do not want to change your password.</p>

                        <div class="mb-3">
                            <label for="current_password" class="form-label fw-semibold">Current Password</label>
                            <input 
                                type="password" 
                                class="form-control" 
                                id="current_password" 
                                name="current_password"
                            >
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="new_password" class="form-label fw-semibold">New Password</label>
                                <input 
                                    type="password" 
                                    class="form-control" 
                                    id="new_password" 
                                    name="new_password"
                                >
                            </div>
                            <div class="col-md-6">
                                <label for="confirm_password" class="form-label fw-semibold">Confirm New Password</label>
                                <input 
                                    type="password" 
                                    class="form-control" 
                                    id="confirm_password" 
                                    name="confirm_password"
                                >
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 pt-2">
                            <a href="/customer/profile.php" class="btn btn-light rounded-pill px-4">Cancel</a>
                            <button type="submit" class="btn btn-primary rounded-pill px-4 fw-semibold">Save Changes</button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>

    <script src="../css/bootstrap.min.js"></script>
</body>
</html>