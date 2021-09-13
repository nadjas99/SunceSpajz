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
	
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://fonts.googleapis.com/css?family=Oswald:400,700&display=swap" rel="stylesheet"> 
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
	<link rel="stylesheet" href="style.css">
</head>
<body onload="ucitajKorpu();">
  <?php include "inc/nav.php"; ?>
  <div class="container">
    
    <div class="row">
      <div class="col-lg-12">
        <div class="page-header">
          <h1>Korpa</h1>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12">
        <button class="btn btn-success btn-lg" onclick="otvoriModal();">Naruci</button>
        <table class="table">
          <thead>
            <tr>
              <th>Naziv proizvod</th>
              <th>Cena</th>
              <th>Kolicina</th>
              <th>Ukupno</th>
              <th>Obrisi</th>
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
          <h4 class="modal-title" id="myModalLabel">Unos adrese</h4>
        </div>
        <div class="modal-body">
          <p> Unesite adresu:</p>
          <div class="form-group">
            <label for="adresa">Adresa</label>
            <input type="text" class="form-control" id="adresa" name="adresa" placeholder="Adresa...">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Zatvori</button>
          <button type="button" class="btn btn-primary" onclick="posaljiPorudzbinu();">Posalji</button>
        </div>
      </div>
    </div>
  </div>
  <script
  src="https://code.jquery.com/jquery-3.4.1.js"
  integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
  crossorigin="anonymous"></script>
 
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
  <script>
    function ucitajKorpu() {
      $.get( "controller.php?akcija=vratiProizvodeIzKorpe", function( json ) {
        var data = JSON.parse(json);
        $("table tbody").empty();
        if(data.status==0) {
          alert(data.poruka);
        } else {
          $.each( data, function( key, value ) {
            $("table tbody").append("<tr><td>"+value.proizvod+"</td><td>"+value.cena+" EUR</td><<td>"+value.kolicina+"</td>td><td>"+value.ukupno+" EUR</td><td><button class='btn btn-primary btn-sm' onclick='obrisiIzKorpe("+value.proizvod_id+")'>Obrisi proizvod</button></td></tr>");
          });
        }
      });
    }

    function posaljiPorudzbinu() {
      var adresa = $("#adresa").val();
      if(adresa.length == 0) {
        alert("Unesite adresu!"); 
      } else {
        var json_proizvod = '{"adresa":"'+adresa+'"}';
        console.log(json_proizvod);
        $.post( "controller.php?akcija=posaljiPorudzbinu", json_proizvod , function( json ) {
          var data = JSON.parse(json);
          alert(data.poruka);
           $(".modal").modal("hide");
           $("#adresa").val("");
           ucitajKorpu();
        });
      }
      
    }
    
    function otvoriModal() {
      $(".modal").modal("show");
    }


    function obrisiIzKorpe(id) {
      $.get( "controller.php?akcija=obrisiProizvodIzKorpe&proizvod_id="+id, function( json ) {
        var data = JSON.parse(json);
        alert(data.poruka);
        ucitajKorpu();
      });
    }

  </script>
</body>
</html>