<?php
include "connect.php";

$naziv = "";
$kategorija = "";
$podkategorija = "";
$cena = 0;
$statusP = "";
$pol = "";
$datum = date('Y-m-d H:i:s');
$slika = "";

$naziv = $_POST['naziv'];
$kategorija = $_POST['kategorija'];
$podkategorija = $_POST['podkategorija'];
$cena = $_POST['cena'];
$statusP = $_POST['statusP'];
$pol = $_POST['pol'];


$source = $_FILES['upload']['tmp_name'];
$target = '../img/' . $_FILES['upload']['name'];
$slika = $_FILES['upload']['name'];
move_uploaded_file($source, $target);

$upit = "INSERT INTO proizvod (Naziv, Kategorija, Podkategorija, Cena, StatusP, DatumRegistracije, Slika, Pol) VALUES
       ('$naziv','$kategorija','$podkategorija','$cena','$statusP','$datum','$slika','$pol')";

if ($rez = $mysqli->query($upit)) {
    header("location: ../index.php");
} else {
    echo "Greska";
}
$mysqli->close();
?>