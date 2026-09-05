<?php

session_start();

if ($_SESSION['user']['admin']) {
    header("Location: /store-project/admin/users/users-table.php");
    exit();
} else {
    header("Location: /store-project/customer/home.php");
    exit();
}