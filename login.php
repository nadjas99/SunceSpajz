<?php 	
	session_start();
	if(isset($_SESSION['userid'])) {
	    header("Location: index.php");
	  }
	include "konekcija.php";

	if(isset($_POST['submit'])) {
		if(empty($_POST['username']) || empty($_POST['password'])) {
			$msg = "Unesite username i password";
		} else {
			$username = $_POST['username'];
			$password = $_POST['password'];

			$username = $mysqli->real_escape_string($username);
			$password = $mysqli->real_escape_string($password);
			
			$sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
			if($q=$mysqli->query($sql)){
				if(mysqli_num_rows($q)>0) {
					$red = $q->fetch_object();
					$_SESSION['userid'] = $red->id;
					$_SESSION['admin'] = $red->admin;

					if($red->admin == 0) {
						header("Location: index.php");
					} else {
						header("Location: admin.php");
					}

				} else {		
					$msg = "Pogresan username i password";
				}
			} else {
				
				$msg = "Greska sa bazom.";
			}

		}
	}
 ?>


<!DOCTYPE html>
<html>
<head>
	<title>SportPro</title>
	<!-- Latest compiled and minified CSS -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="row">
		<div class="col-lg-4 col-xs-12"></div>
		<div class="col-lg-4 col-xs-12">
			<div class="well login-form">
				<form action="" method="POST">
				  	<h1 class="text-center">Login</h1>
				  	<?php 	
				  		if(isset($msg)) {
				  			?>
				  			<div class="alert alert-info text-center"><?php echo $msg; ?></div>
				  			<?php
				  		}
				  	 ?>
					<div class="form-group">
					    <label for="username">Username</label>
					    <input type="text" class="form-control" id="username" name="username" placeholder="Username...">
					  </div>
					  <div class="form-group">
					    <label for="password">Password</label>
					    <input type="password" class="form-control" id="password" name="password" placeholder="Password...">
					  </div>
					  <button type="submit" name="submit" class="btn btn-primary btn-block">Login</button>
				</form>
			</div>
		</div>
		<div class="col-lg-4 col-xs-12"></div>
	</div>



	<!-- Latest compiled and minified JavaScript -->
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
</body>
</html>