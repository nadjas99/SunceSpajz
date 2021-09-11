<?php
session_start();
if(!isset($_SESSION['userid']) || $_SESSION['admin'] !=1) {
  header("Location: login.php");
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>SportPro</title>
	
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://fonts.googleapis.com/css?family=Oswald:400,700&display=swap" rel="stylesheet"> 
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
	<link rel="stylesheet" href="style.css">
</head>
<body onload="ucitajNeobradjenePorudzbine(); ucitajObradjenePorudzbine();">
  <?php include "inc/nav.php"; ?>
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="page-header">
          <h1>Porudzbine</h1>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12">
        <p>Sve neobradjene porudzbine</p>
        <table class="table"  id="neobradjene_porudzbine">
          <thead>
            <tr>
              <th>Korisnik</th>
              <th>Vreme</th>
              <th>Adresa</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>

          </tbody>
        </table>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12">
        <p>Sve obradjene porudzbine</p>
        <table class="table" id="obradjene_porudzbine">
          <thead>
            <tr>
              <th>Korisnik</th>
              <th>Vreme</th>
              <th>Adresa</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>

          </tbody>
        </table>
      </div>
    </div>
  </div>
  <script
  src="https://code.jquery.com/jquery-3.4.1.js"
  integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
  crossorigin="anonymous"></script>

  <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
  <script>
    function ucitajNeobradjenePorudzbine() {
      $.get( "controller.php?akcija=vratiNeobradjenePorudzbine", function( json ) {
        var data = JSON.parse(json);
        $("#neobradjene_porudzbine tbody").empty();
         $.each( data, function( key, value ) {
            $("#neobradjene_porudzbine tbody").append("<tr><td>"+value.username+"</td><td>"+value.time_ordered+" </td><<td>"+value.address+"</td><td><button class='btn btn-success btn-sm' onclick='prihvatiPorudzbinu("+value.id+")'>Prihvati</button></td></tr>");
          });
      });
    }

    function ucitajObradjenePorudzbine() {
      $.get( "controller.php?akcija=vratiObradjenePorudzbine", function( json ) {
        var data = JSON.parse(json);
        $("#obradjene_porudzbine tbody").empty();
         $.each( data, function( key, value ) {
            $("#obradjene_porudzbine tbody").append("<tr><td>"+value.username+"</td><td>"+value.time_ordered+" </td><<td>"+value.address+"</td><td>Prhivaceno</td></tr>");
          });
      });
    }

    function prihvatiPorudzbinu(id) {
      $.get( "controller.php?akcija=promeniStatusPorudzbine&order_id="+id, function( json ) {
        ucitajObradjenePorudzbine();
        ucitajNeobradjenePorudzbine();
      });
    }

  </script>
</body>
</html>