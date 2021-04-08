<?php
include "connect.php";
$newStatus = $_POST['newStatus'];
$newCena = $_POST['newCena'];
$naziv = $_POST['naziv'];
$upit = "UPDATE proizvod SET StatusP='$newStatus', Cena='$newCena' WHERE Naziv LIKE '$naziv'";
if (!$rez = $mysqli->query($upit)) {
    echo "Greska: " . $mysqli->error;
} else {
    echo "Success";
}

$mysqli->close();
?>
