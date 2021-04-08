<?php
session_start();
if (isset($_SESSION['cart'])) {

    foreach ($_POST as $k => $v) {
        if (strpos($k, 'quantity') !== false && is_numeric($v)) {
            $qname = str_replace('quantity-', '', $k);
            $quantity = (int)$v;

            if (isset($_SESSION['cart'][$qname]) && $quantity > 0) {
                $_SESSION['quantity'] = $_SESSION['quantity'] - $_SESSION['cart'][$qname] + $quantity;
                $_SESSION['cart'][$qname] = $quantity;
            }
        }
    }

    echo "Success";
} else {
    echo "Error";
}


?>