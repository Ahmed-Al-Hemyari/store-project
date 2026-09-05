<?php

require_once "../classes.php";
require_once "./components/navbar.php";

session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['admin'] == false) {
    header("Location: /store-project/auth/login.php");
    exit();
}

$user = User::find($_SESSION['user']['id']) ?? null;
if (!$user) {
    unset($_SESSION['user']);
    header("Location: /store-project/auth/login.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <title>OnlineStore - Profile</title>
</head>
<body>
    <?php render_navbar(); ?>
    <div class="container my-5">
        <div class="row g-4">
            <div class="">
                <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                    <div class="bg-primary p-4 text-center text-white">
                        <div class="rounded-circle bg-white text-primary d-inline-flex align-items-center justify-content-center mb-3 shadow-sm" style="width: 80px; height: 80px; font-size: 32px; font-weight: bold;">
                            <?= strtoupper(substr($user->name ?? 'U', 0, 1)); ?>
                        </div>
                        <h5 class="mb-1 fw-bold"><?= htmlspecialchars($user->name); ?></h5>
                        <span class="badge bg-light text-dark fw-normal px-3 py-1 rounded-pill">
                            <?= $user->admin ? 'Administrator' : 'Customer'; ?>
                        </span>
                    </div>
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="text-uppercase text-muted fw-bold m-0 fs-7" style="letter-spacing: 0.5px;">Account Information</h6>
                            <a href="/store-project/admin/edit-profile.php" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                Edit
                            </a>
                        </div>
                        
                        <div class="mb-3">
                            <label class="small text-muted d-block">Full Name</label>
                            <span class="fw-semibold text-dark"><?= htmlspecialchars($user->name); ?></span>
                        </div>
                        
                        <div class="mb-3">
                            <label class="small text-muted d-block">Email Address</label>
                            <span class="fw-semibold text-dark"><?= htmlspecialchars($user->email); ?></span>
                        </div>

                        <div class="mb-0">
                            <label class="small text-muted d-block">Phone Number</label>
                            <span class="fw-semibold text-dark"><?= htmlspecialchars(empty($user->phone) ? 'Not provided' : $user->phone); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</body>
</html>