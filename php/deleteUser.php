<?php
include "connect.php";
$ime = "";

$ime = $mysqli->real_escape_string($_POST['ime']);
$upit = "DELETE FROM nalog WHERE Ime LIKE '$ime'";
if (!$rez = $mysqli->query($upit)) {
    die("Greska: " . $mysqli->error);
}

$mysqli->close();
?>