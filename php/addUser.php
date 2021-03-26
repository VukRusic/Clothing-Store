<?php
      include "connect.php";
      $ime = 0;
      $prezime = 0;
      $password = 0;
      $email = 0;

      $ime = $_POST['Ime'];
      $prezime = $_POST['Prezime'];
      $password = $_POST['Password1'];
      $email = $_POST['Email'];
      $tip = "korisnik";

      $hashedpassword = hash('sha512', $password);

      $upit = "INSERT INTO nalog (Ime, Prezime, Email, Sifra, Tip) VALUES
       ('$ime','$prezime','$email','$password','$tip')";
      if ($rez = $mysqli->query($upit)) {
        echo "Uspesna registracija";
      }
      else {
        echo "Greska";
      }
      $mysqli->close();
?>