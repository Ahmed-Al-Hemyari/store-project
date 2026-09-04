<?php

session_start();

if ($_SESSION['user']['admin']) {
    header("Location: /admin/users/users-table.php");
    exit();
} else {
    header("Location: /customer/home.php");
    exit();
}