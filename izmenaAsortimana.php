<?php
session_start();
if(!isset($_SESSION['userid']) || $_SESSION['admin'] !=1) {
  header("Location: login.php");
}
include "konekcija.php";
if(isset($_POST['submit'])) {
    if(empty($_POST['naziv']) || empty($_POST['cena'])) {
      $msg = 'Popunite sva polja!';
    } else {
      $naziv = $_POST['naziv'];
      $cena = $_POST['cena'];

      $naziv = $mysqli->real_escape_string($naziv);
      $cena = $mysqli->real_escape_string($cena);
      $sql = "INSERT INTO products (product_name, price) VALUES ('".$naziv."', '".$cena."')";
      if($q = $mysqli->query($sql)) {
        $msg = "Uspesno unet proizvod";
      } else {
        $msg = "Greska sa bazom!";
      }

    }
}
if(isset($_POST['submitObrisi'])) {
    if(empty($_POST['proizvod'])) {
      $msgobrisi = 'Popunite sva polja!';
    } else {
      $proizvod = $_POST['proizvod'];

      $proizvod = $mysqli->real_escape_string($proizvod);
      $sql = "DELETE FROM products WHERE id='$proizvod'";
      if($q = $mysqli->query($sql)) {
        $msgobrisi = "Uspesno izbrisan proizvod";
      } else {
        $msgobrisi = "Greska sa bazom!";
      }

    }
}
if(isset($_POST['submitIzmeni'])) {
    if(empty($_POST['proizvod']) || empty($_POST['cena'])) {
      $msgizmena = 'Popunite sva polja!';
    } else {
      $proizvod = $_POST['proizvod'];
      $cena = $_POST['cena'];

      $proizvod = $mysqli->real_escape_string($proizvod);
      $cena = $mysqli->real_escape_string($cena);
      $sql = "UPDATE products SET price='$cena' WHERE id='$proizvod'";
      if($q = $mysqli->query($sql)) {
        $msgizmena = "Uspesno izmenjena cena";
      } else {
        $msgizmena = "Greska sa bazom!";
      }

    }
}
$sql="SELECT * FROM products";
$q=$mysqli->query($sql);
$q1=$mysqli->query($sql);
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

    <div class="row">
      <div class="col-lg-12">
        <div class="page-header">
          <h1>Svi proizvodi</h1>
        </div>
      </div>
    </div>
    <div class="row">
    <div class="col-lg-4"></div>
      <div class="col-lg-4">
      <div class="well">
        <?php 
          if(!empty($msg)){
            ?>
              <div class="alert alert-info text-center"><?php echo $msg; ?></div>
            <?php
          }
         ?>
         <form action="" method="POST">
           <div class="form-group">
            <label for="naziv">Naziv</label>
            <input type="text" class="form-control" id="naziv" name="naziv" placeholder="Naziv...">
          </div>
          <div class="form-group">
            <label for="cena">Cena</label>
            <input type="text" class="form-control" id="cena" name="cena" placeholder="Cena...">
          </div>
          <input type="submit" name="submit" value="Dodaj" class="btn btn-primary btn-block">
         </form>
      </div>
      </div>
      <div class="col-lg-4"></div>  
    </div>
    <div class="row">
    <div class="col-lg-4"></div>
      <div class="col-lg-4">
      <div class="well">
        <?php 
          if(!empty($msgobrisi)){
            ?>
              <div class="alert alert-info text-center"><?php echo $msgobrisi; ?></div>
            <?php
          }
         ?>
         <form action="" method="POST">
           <div class="form-group">
            <label for="naziv">Prozivod</label>
            <select name="proizvod" id="proizvod" class="form-control">
              <?php 
                  while($red=$q->fetch_object()) {
                    ?>
                      <option value="<?php echo $red->id; ?>"><?php echo $red->product_name; ?></option>
                    <?php
                  }
               ?>
            </select>
          </div>
          <input type="submit" name="submitObrisi" value="Obrisi" class="btn btn-primary btn-block">
         </form>
      </div>
      </div>
      <div class="col-lg-4"></div>  
    </div>
    <div class="row">
    <div class="col-lg-4"></div>
      <div class="col-lg-4">
      <div class="well">
        <?php 
          if(!empty($msgizmena)){
            ?>
              <div class="alert alert-info text-center"><?php echo $msgizmena; ?></div>
            <?php
          }
         ?>
         <form action="" method="POST">
           <div class="form-group">
            <label for="naziv">Prozivod</label>
            <select name="proizvod" id="proizvod" class="form-control">
              <?php 
                  while($red1=$q1->fetch_object()) {
                    ?>
                      <option value="<?php echo $red1->id; ?>"><?php echo $red1->product_name; ?></option>
                    <?php
                  }
               ?>
            </select>
          </div>
          <div class="form-group">
            <label for="cena">Cena</label>
            <input type="text" class="form-control" id="cena" name="cena" placeholder="Cena...">
          </div>
          <input type="submit" name="submitIzmeni" value="Izmeni" class="btn btn-primary btn-block">
         </form>
      </div>
      </div>
      <div class="col-lg-4"></div>  
    </div>
  
  </div>

  <script
  src="https://code.jquery.com/jquery-3.4.1.js"
  integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
  crossorigin="anonymous"></script>
  <!-- Latest compiled and minified JavaScript -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>

</body>
</html>