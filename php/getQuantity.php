<?php
session_start();
if (isset($_SESSION['quantity'])) {
    echo json_encode($_SESSION['quantity']);
}
?>