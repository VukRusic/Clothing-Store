<?php
session_start();
include "connect.php";
$idPorudzbine = $_POST['id'];
$upit = "SELECT * FROM `proizvod_narudzbenica` WHERE IdNarudz='$idPorudzbine'";
if (!$rez = $mysqli->query($upit)) {
    echo "Greska: " . $mysqli->error;
} else {
    $pns = $rez->fetch_all();
}
?>

<table class="status">
    <thead>
        <tr>
            <td>Naziv</td>
            <td>Kolicina</td>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($pns as $pn) : ?>
            <tr>
                <td><?= $pn[1] ?></td>
                <td><?= $pn[3] ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>