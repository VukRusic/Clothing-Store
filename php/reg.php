<div class="login-page">
  <div class="formRegister">
    <form class="register-form" id="formRegister" method="post">
      <input type="text" placeholder="Ime" name="Ime" required/>
      <input type="text" placeholder="Prezime" name="Prezime" required/>
      <input type="password" placeholder="Sifra" name="Password1" required/>
      <input type="text" placeholder="Email" name="Email" required/>
    </form>
    <button id="registerBtn" name="kreiraj">Kreiraj nalog</button>
  </div>
  <script>
    $('#registerBtn').click(function() {
      var form = $('#formRegister').serialize();
      $.ajax({
        url: "php/addUser.php",
        method: "POST",
        data: form,
        success: function(response) {
          if(response == "Success"){
            window.location.reload();
          } else {
            alert("Niste popunili sva polja");
          }
        }
      });
    });
  </script>
</div>