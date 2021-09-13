<?php
session_start();
if(!isset($_SESSION['userid'])) {
  header("Location: login.php");
}
include "konekcija.php";
$sql = "SELECT * FROM orders_list as ol JOIN orders as o ON o.id=ol.order_id JOIN products as p ON p.id = ol.product_id JOIN users as u ON u.id = o.user_id";
$q=$mysqli->query($sql);

?>
<!DOCTYPE html>
<html>
<head>
	<title>Sunce</title>
	<!-- Latest compiled and minified CSS -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://fonts.googleapis.com/css?family=Oswald:400,700&display=swap" rel="stylesheet"> 
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
	<link rel="stylesheet" href="style.css">
</head>
<body>
  <?php include "inc/nav.php"; ?>
  <div class="container">

    <div class="row">
      <div class="col-lg-12">
        <div class="page-header">
          <h1>Svi proizvodi</h1>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12">
        <table class="table">
          <thead>
            <tr>
              <th>Korisnik</th>
              <th>Naziv proizvod</th>
              <th>Cena</th>
              <th>Kolicina</th>
              <th>Adresa</th>
            </tr>
          </thead>
          <tbody>
            <?php while($red=$q->fetch_object()) {
              ?>
                <tr>
                  <td><?php echo $red->username; ?></td>
                  <td><?php echo $red->product_name; ?></td>
                  <td><?php echo $red->price; ?> EUR</td>
                  <td><?php echo $red->quantity; ?></td>
                  <td><?php echo $red->address; ?></td>
                </tr>
              <?php
              } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <script
  src="https://code.jquery.com/jquery-3.4.1.js"
  integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
  crossorigin="anonymous"></script>
  <!-- Latest compiled and minified JavaScript -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
  <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
  <script>
    $(document).ready( function () {
      $('table').DataTable({
         "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.20/i18n/Serbian_latin.json"
            }
      });
  } );
  </script>
</body>
</html>