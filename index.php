<?php

session_start();

if ($_SESSION['user']['admin']) {
    header("Location: /admin/panel.php");
} else {
    header("Location: /customer/home.php");
}