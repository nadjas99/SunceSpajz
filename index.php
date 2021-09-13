<?php
session_start();
if(!isset($_SESSION['userid'])) {
  header("Location: login.php");
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Sunce</title>
	<!-- Latest compiled and minified CSS -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://fonts.googleapis.com/css?family=Oswald:400,700&display=swap" rel="stylesheet"> 
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
	<link rel="stylesheet" href="style.css"> 
</head>
<body>
  <?php include "inc/nav.php"; ?>
  <div class="container">
    <div class="row d-flex justify-content-center">
      <div class="col-lg-12 d-flex justify-content-center">
        <?php include "inc/jumbo.php"; ?>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12">
        <div class="page-header">
          <h1>Svi naši proizvodi u ponudi</h1>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12">
        <table class="table">
          <thead class="tabela">
            <tr>
              <th>Naziv proizvoda</th>
              <th>Cena</th>
              <th>Dodaj proizvod u korpu</th>
            </tr>
          </thead>
          <tbody>

          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Unos količine</h4>
        </div>
        <div class="modal-body">
          <p> Unesite količinu:</p>
          <div class="form-group">
            <label for="kolicina">Količina</label>
            <input type="text" class="form-control" id="kolicina" name="kolicina" placeholder="Kolicina...">
          </div>
          <input type="text" class="form-control" id="product_id" name="product_id" style="display: none;">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Zatvori</button>
          <button type="button" class="btn btn-primary" onclick="dodajProizvodUKorpu();">Dodaj proizvod</button>
        </div>
      </div>
    </div>
  </div>
  <script
  src="https://code.jquery.com/jquery-3.4.1.js"
  integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
  crossorigin="anonymous"></script>
  <!-- Latest compiled and minified JavaScript -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
  <script>
    $.get( "controller.php?akcija=vratiProizvode", function( json ) {
      var data = JSON.parse(json);
      // var dollar_rate = "";
      $.each( data, function( key, value ) {
        $("table tbody").append("<tr><td>"+value.product_name+"</td><td>"+value.price+" rsd </td><td><button class='btn btn-secondary btn-sm' onclick='otvoriModal("+value.id+")'>Dodaj u korpu</button></td></tr>");
      });
    });

    function otvoriModal(id) {
      $("#product_id").val(id);
      $(".modal").modal("show");
    }

    function Proizvod(kolicina, product_id) {
      this.kolicina = kolicina;
      this.product_id = product_id;
    }

    function dodajProizvodUKorpu() {
      var kolicina = $("#kolicina").val();
      var product_id = $("#product_id").val();
      if(kolicina.length == 0) {
        alert("Unesite kolicinu!"); 
      } else {
        var proizvod = new Proizvod(kolicina, product_id);
        var json_proizvod = JSON.stringify(proizvod);
        $.post( "controller.php?akcija=dodajProizvodUKorpu", json_proizvod , function( json ) {
          var data = JSON.parse(json);
          alert(data.poruka);
           $(".modal").modal("hide");
           $("#kolicina").val("");
        });
      }
      
    }
  </script>
</body>
</html>