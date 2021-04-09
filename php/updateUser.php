<?php
session_start();
include "connect.php";

if ($_POST['Username'] != "" && $_POST['Prezime'] != "" && $_POST['Sifra'] != "" && $_POST['Email'] != "") {
    $id = $_POST['Id'];
    $ime = $_POST['Username'];
    $prezime = $_POST['Prezime'];
    $email = $_POST['Email'];
    $sifra = $_POST['Sifra'];

    $upit = "select id from nalog where email='$email'";
    if ($rez = $mysqli->query($upit)) {
        if ($red = $rez->fetch_assoc())
            die("Već je kreiran nalog za uneto ime ili email.");
    }

    $upit = "UPDATE nalog set Ime='$ime', Prezime='$prezime', Email='$email', Sifra='$sifra'
    WHERE Id LIKE '$id'";

    if (!$rez = $mysqli->query($upit)) {
        echo "Greska";
    } else {
        $_SESSION['username'] = $ime;
        echo "Success";
    }
} else {
    echo "Niste popunili sva polja.";
}
?>