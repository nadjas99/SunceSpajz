<?php 
	session_start();
	include "konekcija.php";
	if(isset($_GET['akcija']) && $_GET['akcija']=="vratiProizvode") {
		$sql="SELECT * FROM products";
		if($q=$mysqli->query($sql)) {
			$niz = array();
			while($red = $q->fetch_object()) {
				$niz[] = $red;
			}
			echo json_encode($niz);
		} else {
			$odgovor['poruka'] = "Greska sa bazom";
			echo json_encode($odgovor);
		}
	}

	if(isset($_GET['akcija']) && $_GET['akcija']=="dodajProizvodUKorpu") {
		$podaci_json = file_get_contents("php://input");
		$podaci = json_decode($podaci_json);
		if($_SESSION['korpa'][$podaci->product_id] = $podaci->kolicina) {
			$odgovor['poruka'] = "Proizvod je uspesno ubacen.";
			echo json_encode($odgovor);
		} else {
			$odgovor['poruka'] = "Doslo je do greske";
			echo json_encode($odgovor);
		}

	}

	
	if(isset($_GET['akcija']) && $_GET['akcija']=="vratiNeobradjenePorudzbine") {
		$sql="SELECT o.*, u.username FROM orders as o JOIN users as u ON o.user_id = u.id WHERE status=0";
		if($q=$mysqli->query($sql)) {
			$niz = array();
			while($red = $q->fetch_object()) {
				$niz[] = $red;
			}
			echo json_encode($niz);
		} else {
			$odgovor['poruka'] = "Greska sa bazom";
			echo json_encode($odgovor);
		}
	}

	if(isset($_GET['akcija']) && $_GET['akcija']=="vratiObradjenePorudzbine") {
		$sql="SELECT o.*, u.username FROM orders as o JOIN users as u ON o.user_id = u.id WHERE status=1";
		if($q=$mysqli->query($sql)) {
			$niz = array();
			while($red = $q->fetch_object()) {
				$niz[] = $red;
			}
			echo json_encode($niz);
		} else {
			$odgovor['poruka'] = "Greska sa bazom";
			echo json_encode($odgovor);
		}
	}

	if(isset($_GET['akcija']) && $_GET['akcija']=="promeniStatusPorudzbine") {
		$order_id = $_GET['order_id'];
		$sql="UPDATE orders SET status=1 WHERE id='$order_id'";
		if($q=$mysqli->query($sql)) {
			$odgovor['poruka'] = "Promenjen status porudzbine.";
			echo json_encode($odgovor);
		} else {
			$odgovor['poruka'] = "Greska sa bazom";
			echo json_encode($odgovor);
		}

	}
    if(isset($_GET['akcija']) && $_GET['akcija']=="vratiProizvodeIzKorpe") {
		if(isset($_SESSION['korpa'])) {
			$niz = array();
			$sql="SELECT * FROM products";
			if($q=$mysqli->query($sql)) {
				$proizvodi = array();
				while($red = $q->fetch_object()) {
					$proizvodi[$red->id] = $red;
				}
				foreach ($_SESSION['korpa'] as $key => $value) {
					$odgovor['proizvod_id'] = $key;
					$odgovor['proizvod'] = $proizvodi[$key]->product_name;
					$odgovor['kolicina'] = $value;
					$odgovor['cena'] = $proizvodi[$key]->price;
					$odgovor['ukupno'] = floatval($proizvodi[$key]->price)*$value;
					$niz[] = $odgovor;
				}
				echo json_encode($niz);
			} else {
				$odgovor['status'] = 0;
				$odgovor['poruka'] = "Greska sa bazom";
				echo json_encode($odgovor);
			}
		} else {
			$odgovor['status'] = 0;
			$odgovor['poruka'] = "Nema proizvoda u korpi.";
			echo json_encode($odgovor);
		}
	}
    if(isset($_GET['akcija']) && $_GET['akcija']=="posaljiPorudzbinu") {
		$podaci_json = file_get_contents("php://input");
		$podaci = json_decode($podaci_json);
		$adresa = $mysqli->real_escape_string($podaci->adresa);
		$sql="INSERT INTO orders (user_id, time_ordered, address) VALUES ('".$_SESSION['userid']."', NOW(), '".$adresa."')";
		if($q=$mysqli->query($sql)){
			$order_id = $mysqli->insert_id;
			foreach ($_SESSION['korpa'] as $key => $value) {
					$sql2="INSERT INTO orders_list (order_id, product_id, quantity) VALUES('".$order_id."', '".$key."', '".$value."')";
					$q2=$mysqli->query($sql2);
				}
			unset($_SESSION['korpa']);
			$odgovor['status'] = 1;
			$odgovor['poruka'] = "Porudzbina je poslata!";
			echo json_encode($odgovor);
		} else {
			$odgovor['status'] = 0;
			$odgovor['poruka'] = "Greska sa bazom".mysqli_error($mysqli);
			echo json_encode($odgovor);
		}

	}
    if(isset($_GET['akcija']) && $_GET['akcija']=="obrisiProizvodIzKorpe") {
		$id_proizvoda = $_GET['proizvod_id'];
		unset($_SESSION['korpa'][$id_proizvoda]);
		$odgovor['poruka'] = "Proizvod je uspesno obrisan iz korpe.";
		echo json_encode($odgovor);

	}

	
	

 ?>