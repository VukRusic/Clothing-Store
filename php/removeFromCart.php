<?php
session_start();
$remove = $_GET['remove'];

if (isset($_GET['remove']) && isset($_SESSION['cart']) && isset($_SESSION['cart'][$_GET['remove']])) {
    $_SESSION['quantity'] -= $_SESSION['cart'][$_GET['remove']];
    unset($_SESSION['cart'][$_GET['remove']]);
}

?>