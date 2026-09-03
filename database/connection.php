<?php

$host = "127.0.0.1";
$user = "root";
$password = "";
$db = "store";

$connection = mysqli_connect($host, $user, $password, $db);

if (!$connection) {
    die("Error connecting to Database");
}