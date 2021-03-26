<?php
include "connect.php";
$ime = "";

$ime = $_POST['ime'];
$upit = "DELETE FROM nalog WHERE Ime LIKE '$ime'";
if (!$rez = $mysqli->query($upit)) {
    die("Greska: " . $mysqli->error);
}

$mysqli->close();
?>