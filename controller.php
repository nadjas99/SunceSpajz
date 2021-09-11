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

	
	

 ?>