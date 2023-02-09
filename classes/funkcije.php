<?php
function obradiSlika() {
	if ( isset( $_FILES["slika"] ) and $_FILES["slika"]["error"] == UPLOAD_ERR_OK ) {
	  if ($_FILES["slika"]["type"] != "image/png") {
		echo "<script>alert(\"Samo .png format fotografije!\")</script>";
	  } else if ( !move_uploaded_file( $_FILES["slika"]["tmp_name"], "images/" . basename( $_FILES["slika"]["name"] ) ) ) {
		echo "<script>alert(\"Doslo je do greske prilikom slanja slike. " . $_FILES["slika"]["error"] . "\")</script>";
	  } else {
		return true;
	  }
	} else {
	  switch( $_FILES["slika"]["error"] ) {
		case UPLOAD_ERR_INI_SIZE:
		  $message = "Velicina je veca od dozvoljene serverske velicine.";
		  break;
		case UPLOAD_ERR_FORM_SIZE:
		  $message = "Velicina je veca od dozvoljene script velicine.";
		  break;
		case UPLOAD_ERR_NO_FILE:
		  $message = "Niste odabrali fajl za postavljanje.";
		  break;
		default:
		  $message = "Molim Vas kontaktirajte IT podrsku.";
	  }
	  echo "<script>alert(\"Doslo je do problema prilikom postavljanja slike. $message\");</script>";
	  return false;
	}
}

function cmp($a, $b) {
    return strcmp($a->getNaziv(), $b->getNaziv());
}
function cmpCena($a, $b) {
    return ($a->getCena()) - ($b->getCena());
}

?>