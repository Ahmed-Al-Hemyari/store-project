<?php

session_start();

if ($_SESSION['user']['admin']) {
    header("Location: /admin/users/table.php");
} else {
    header("Location: /customer/home.php");
}