<?php
session_start();
include "connect.php";
$email = $mysqli->real_escape_string($_POST['Email']);
$password = $mysqli->real_escape_string($_POST['Password']);

$upit = "SELECT * FROM nalog WHERE Email='$email' and Sifra='$password'";

if (!$rez = $mysqli->query($upit)) {
    die("Greska: " . $mysqli->error);
} else {
    if (!$nalog = $rez->fetch_assoc()) {
        die("Neispravni podaci");
    } else {
        $ime = $nalog['Ime'];
        $_SESSION['username'] = $ime;
        $_SESSION['quantity'] = 0;
        if ($ime == "admin") {
            echo "admin";
        } else {
            echo "success";
        }
    }
}
$mysqli->close();
?>