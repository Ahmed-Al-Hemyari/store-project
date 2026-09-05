<?php

$host = "127.0.0.1";
$user = "root";
$password = "";
$db = "store";

try {
    $connection = new
    PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Successfully connected to database";
} catch (PDOException $e) {
    echo "Failed to connect to database!" . $e->getMessage();
}