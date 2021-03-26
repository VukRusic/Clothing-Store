<?php
session_start();
$name = $_POST['name'];
if (isset($_SESSION['username'])) {

    $_SESSION['quantity'] += 1;

    if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {

        if (array_key_exists($name, $_SESSION['cart'])) {
            $_SESSION['cart'][$name] += 1;
        } else {
            $_SESSION['cart'][$name] = 1;
        }
    } else {
        $singleQuantity = 1;
        $_SESSION['cart'] = array($name => $singleQuantity);
    }
    if (isset($_SESSION['quantity'])) {
        echo json_encode($_SESSION['quantity']);
    }
} else {
    echo "error";
}
?>
