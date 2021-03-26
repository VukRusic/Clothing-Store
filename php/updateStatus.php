<?php
session_start();
include "connect.php";
$id = "";
$statusp = "";

$statusp = $_POST['newStatus'];
$id = $_POST['id'];
$upit = "UPDATE narudzbenica SET StatusP='$statusp' WHERE Id = '$id'";
if (!$rez = $mysqli->query($upit)) {
    echo "Greska: " . $mysqli->error;
} else {
    header("location: ../index.php");
}

$mysqli->close();
?>