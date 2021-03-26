<?php
session_start();
if (isset($_GET['remove']) && isset($_SESSION['cart']) && isset($_SESSION['cart'][$_GET['remove']])) {
    $_SESSION['quantity'] -= $_SESSION['cart'][$_GET['remove']];
    unset($_SESSION['cart'][$_GET['remove']]);
}
header("location: ../index.php");
?>