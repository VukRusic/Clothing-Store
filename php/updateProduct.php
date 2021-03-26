<?php
include "connect.php";
$cena = $_POST['cenap'];
$status = $_POST['statusp'];
$naziv = $_POST['nazivp'];

?>
<form id="form2">
    <input type="hidden" name="naziv" value="<?=$naziv?>">
    <label>Cena: </label>
    <input value="<?=$cena?>" name="newCena" size="15"><br>
    <label>Status: </label>
    <input value="<?=$status?>" name="newStatus" size="15"><br>
    <input type="button" onclick="changeStatus()" name="update" value="Sačuvaj promene" class="btn btn-success upbtn">
</form>
<script>
    function changeStatus(){
      var form = $('#form2').serialize();
      $.ajax({
        url: "php/changeStatus.php",
        method: "POST",
        data: form,
        success: function() {
          window.location.reload();
        }
      });
    }
</script>