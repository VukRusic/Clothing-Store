<?php
include "connect.php";
$naziv = "";

$naziv = $_POST['nazivp'];
$upit = "DELETE FROM proizvod WHERE Naziv LIKE '$naziv'";
if (!$rez = $mysqli->query($upit)) {
    echo "Greska: " . $mysqli->error;
} else {
    echo "Uspesno obrisano" . $naziv;
}

$mysqli->close();
?>
