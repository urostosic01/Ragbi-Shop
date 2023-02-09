<?php
require_once "classes/db_utils.php";
require_once "classes/funkcije.php";
session_start();

$errors = [];

$db = new Database();

    if(isset($_POST["login"])){
        $korIme = htmlspecialchars($_POST["korIme"]);  //posto je lozinka cryptovana, parametri za admina
        $lozinka = htmlspecialchars($_POST["lozinka"]);//user: urosT pass:1234
        $rezProvere = $db->loginProvera($korIme, $lozinka);
        if($rezProvere["Uloga_idUloga"] == 1){
            header("Location: home.php");
        } else if($rezProvere["Uloga_idUloga"] == 2) {//parametri za korisnika
            $idKorisnik = $rezProvere["idKorisnik"];  //user: peraP pass:321321
            setcookie("idKorisnik", $idKorisnik, time() + (60*60));
            setcookie("korisnik", $korIme, time() + (60*60));
            header("Location: home_user.php");
        } else if($rezProvere["Uloge_idUloga"] == 0) {//za gosta nisu neophodni parametri
            header("Location: home_guest.php");
        }
    }

	if(isset($_POST["register"])){ //registracija
		if($_POST["imeNov"]) { //provere za setovanje promenljivih
        	$imeNov = htmlspecialchars($_POST["imeNov"]); 
		}
		if($_POST["prezimeNov"]) {
        	$prezimeNov = htmlspecialchars($_POST["prezimeNov"]);
		}
		if($_POST["emailNov"]) {
			$emailNov = htmlspecialchars($_POST["emailNov"]);
		}
		if($_POST["korImeNov"]) {
			$korImeNov = htmlspecialchars($_POST["korImeNov"]);
		}
		if($_POST["lozinkaNov"]) {
			$lozinkaNov = htmlspecialchars($_POST["lozinkaNov"]);
		}        
		if($_POST["lozinka2Nov"]) {
			$lozinka2Nov = htmlspecialchars($_POST["lozinka2Nov"]);
		}
		if(obradiSlika()){  //funkcija iz fajla funkcija.php, prosledjuje sliku preko servera u odgovarajuci folder
			$slikaNov = $_FILES["slika"]["name"];
		}
		if (!$imeNov) { //provere gresaka prilikom unosa, dodatno obezbedjeno sa required poljem u formi
			$errors["ime"] = "Unesite ime";
		}
		if (!$prezimeNov) {
			$errors["prezime"] = "Unesite prezime";
		}
		if (!$emailNov) {
			$errors["email"] = "Unesite email";
		}
		if (!$korImeNov) {
			$errors["korIme"] = "Unesite korisnicko ime";
		}
		if (!$lozinkaNov) {
			$errors["lozinka"] = "Unesite lozinku";
		}
		if (!$lozinka2Nov) {
			$errors["lozinka2"] = "Ponovite lozinku";
		}
		if (!$slikaNov) {
			$errors["slika"] = "Nije dobra slika";
		}
		if($lozinkaNov != $lozinka2Nov){
			$errors["poklapanje"] = "Lozinke se ne poklapaju";
		}

        if(empty($errors)){ //unos korisnika u bazu ako su svi parametri u redu
            if($db->insertKorisnik($imeNov, $prezimeNov, $emailNov, $korImeNov, $lozinkaNov, $slikaNov)){
                echo "<script>alert(\"Uspesna registracija!\");</script>";
            } else {
                echo "<script>alert(\"Neuspesna registracija!\");</script>";
            }
        } 

    }

?>
<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="css/login.css">
  	<link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
</head>
<body>
	<div class="main">  	
		<input type="checkbox" id="chk" aria-hidden="true">

			<div class="login">
				<form method="POST">
					<label for="chk" aria-hidden="true">Ragbi shop</label>
					<input type="text" name="korIme" placeholder="Korisnicko ime">
					<input type="password" name="lozinka" placeholder="Lozinka">
					<button type="submit" name="login">Uloguj se</button>
				</form>
			</div>

			<div class="signup">
				<form method="POST" action="login.php" enctype="multipart/form-data">
					<label for="chk" aria-hidden="true">Registruj se</label>
					<input type="text" name="imeNov" placeholder="Ime" required=""><br>
        			<input type="text" name="prezimeNov" placeholder="Prezime" required=""><br>
        			<input type="email" name="emailNov" placeholder="Email" required=""><br>
        			<input type="text" name="korImeNov" placeholder="Korisnicko ime" required=""><br>
        			<input type="password" name="lozinkaNov" placeholder="Lozinka" required=""><br>
        			<input type="password" name="lozinka2Nov" placeholder="Ponovite lozinku" required=""><br>
					
					<input type="file" name="slika" id="slika" value="">
					<button type="submit" name="register">Registruj se</button>
				</form>
			</div>
	</div>
</body>
</html>