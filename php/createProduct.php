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

if($_POST['naziv'] != "" && $_POST['kategorija'] != "" && $_POST['podkategorija'] != "" && $_POST['cena'] != "" && $_POST['pol'] != ""){
$naziv = $mysqli->real_escape_string($_POST['naziv']);
$kategorija = $mysqli->real_escape_string($_POST['kategorija']);
$podkategorija = $mysqli->real_escape_string($_POST['podkategorija']);
$cena = $mysqli->real_escape_string($_POST['cena']);
$statusP = $mysqli->real_escape_string($_POST['statusP']);
$pol = $mysqli->real_escape_string($_POST['pol']);


$source = $_FILES['upload']['tmp_name'];
$target = '../img/' . $_FILES['upload']['name'];
$slika = $_FILES['upload']['name'];
move_uploaded_file($source, $target);

$upit = "INSERT INTO proizvod (Naziv, Kategorija, Podkategorija, Cena, StatusP, DatumRegistracije, Slika, Pol) VALUES
       ('$naziv','$kategorija','$podkategorija','$cena','$statusP','$datum','$slika','$pol')";

if ($rez = $mysqli->query($upit)) {
    echo "Success";
} else {
    echo "Greska";
}
$mysqli->close();
} else {
    echo "Niste popunili sva polja.";
}
?>