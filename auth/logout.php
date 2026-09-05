<?php

session_start();
unset($_SESSION['user']);
header("Location: /store-project/index.php");
exit();