<div class="login-page">
  <div class="form1">
    <form class="register-form" id="form1" method="post">
      <input type="text" placeholder="Ime" name="Ime" />
      <input type="text" placeholder="Prezime" name="Prezime" />
      <input type="password" placeholder="Sifra" name="Password1" />
      <input type="text" placeholder="Email" name="Email" />
    </form>
    <button id="submit1" name="kreiraj">Kreiraj nalog</button>
  </div>
  <script>
    $('#submit1').click(function() {
      var form = $('#form1').serialize();
      $.ajax({
        url: "php/addUser.php",
        method: "POST",
        data: form,
        success: function() {
          window.location.reload();
        }
      });
    });
  </script>
</div>