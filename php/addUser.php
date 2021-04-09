<?php
      include "connect.php";
      $ime = 0;
      $prezime = 0;
      $password = 0;
      $email = 0;
if($_POST['Ime'] != "" && $_POST['Prezime'] != "" && $_POST['Password1'] != "" && $_POST['Email'] != ""){
      $ime = $mysqli->real_escape_string($_POST['Ime']);
      $prezime = $mysqli->real_escape_string($_POST['Prezime']);
      $password = $mysqli->real_escape_string($_POST['Password1']);
      $email = $mysqli->real_escape_string($_POST['Email']);
      $tip = "korisnik";

      $upit = "select id from nalog where email='$email'";
      if ($rez = $mysqli->query($upit)) {
        if($red = $rez->fetch_assoc())
        die("Već je kreiran nalog za uneti email.");
      }
      $hashedpassword = hash('sha512', $password);

      $upit = "INSERT INTO nalog (Ime, Prezime, Email, Sifra, Tip) VALUES
       ('$ime','$prezime','$email','$password','$tip')";
      if ($rez = $mysqli->query($upit)) {
        echo "Success";
      }
      else {
        echo "Uneto ime je vec zauzeto.";
      }
      $mysqli->close();
} else {
  echo "Niste popunili sva polja.";
}
?>
