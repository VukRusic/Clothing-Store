<?php
session_start();
$ime = "";
$email = "";
$sifra = "";
$prezime = "";
$id = 0;
$porudzbine = "";
$ids = "";

include "connect.php";
$ime = $_SESSION['username'];

$upit = "SELECT * FROM nalog where Ime LIKE '$ime'";

if (!$rez = $mysqli->query($upit)) {
    echo "Greska: " . $mysqli->error;
} else {
    $nalog = $rez->fetch_assoc();
    $id = $nalog["Id"];
    $prezime = $nalog["Prezime"];
    $email = $nalog["Email"];
    $sifra = $nalog["Sifra"];
}

$porudzbine = "";
$upit = "SELECT DISTINCT Id FROM narudzbenica n join proizvod_narudzbenica pn on n.Id=pn.IdNarudz where pn.Nalog='$ime'";
if (!$rez = $mysqli->query($upit)) {
    echo "Greska: " . $mysqli->error;
} else {
    while ($red = $rez->fetch_assoc()) {
        $ids .= ",'" . $red["Id"] . "'";
    }
    $ids = substr($ids, 1);
    if ($ids != "") {
        $upit = "SELECT * FROM narudzbenica WHERE Id in ($ids)";

        if (!$rez = $mysqli->query($upit)) {
            echo "Greska: " . $mysqli->error;
        } else {
            $porudzbine = $rez->fetch_all();
        }
    }
}


if (isset($_POST['submit'])) {

    $ime = $_POST['Username'];
    $prezime = $_POST['Prezime'];
    $email = $_POST['Email'];
    $sifra = $_POST['Sifra'];

    $upit = "UPDATE nalog set Ime='$ime', Prezime='$prezime', Email='$email', Sifra='$sifra'
    WHERE Id LIKE '$id'";

    if (!$rez = $mysqli->query($upit)) {
        echo "Greska: " . $mysqli->error;
    } else {
        $_SESSION['username'] = $ime;
        header("location: ../index.php");
    }
}

$mysqli->close();
?>

<div class="col-md-4">
    <h1>Vaš nalog:</h1>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="Username" class="info-label">Korisničko ime:</label>
        <input type="text" class="info-text" name="Username" value="<?php echo $ime ?>"><br><br>
        <label for="Prezime" class="info-label">Prezime:</label>
        <input type="text" class="info-text" name="Prezime" value="<?php echo $prezime ?>"><br><br>
        <label for="Email" class="info-label">Email:</label>
        <input type="text" class="info-text" name="Email" value="<?php echo $email ?>"><br><br>
        <label for="Sifra" class="info-label">Password:</label>
        <input type="text" class="info-text" name="Sifra" value="<?php echo $sifra ?>"><br><br>
        <input type="submit" name="submit" class="btn btn-primary infobtn" value="Ažuriraj podatke">
    </form>
</div>
<div class="col-md-8">
    <h1>Informacije o vašim porudžbinama:</h1>
    <table class="orders">
        <thead>
            <tr>
                <td>Id</td>
                <td>Datum poručivanja</td>
                <td>Adresa isporuke</td>
                <td>Cena</td>
                <td>Status</td>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($porudzbine)) : ?>
                <tr>
                    <td colspan="5" style="text-align:center;">Niste jos nista porucili.</td>
                </tr>
            <?php else : ?>
                <?php foreach ($porudzbine as $porudzbina) : ?>
                    <tr>
                        <td><?= $porudzbina[0] ?></td>
                        <td><?= $porudzbina[1] ?></td>
                        <td><?= $porudzbina[3] ?></td>
                        <td><?= $porudzbina[2] ?></td>
                        <td><?= $porudzbina[5] ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>