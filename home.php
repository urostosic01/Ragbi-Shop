<?php 
require_once "classes/db_utils.php";
require_once "classes/funkcije.php";

//POCETNA STRANICA ZA ADMINA
//moze da pregleda, sortira, brise postojece i dodaje nove artikle


$db = new Database();
$rez = $db->getAllArtikal2(); //dobavljamo sve artikle za prikaz na stranici

if (isset($_POST["unos"])) {
    $naziv = htmlspecialchars($_POST["nazivArtikla"]);
    $kat = $_POST["kategorijaSelect"];
    $cena = htmlspecialchars($_POST["cenaArtikla"]);
    if (obradiSlika()) {
        $slika = $_FILES["slika"]["name"];
        if ($db->insertArtikal($naziv, $kat, $cena, $slika)) {
            $message = "<h2>USPEO!</h2>";
        } else {
            $message = "<h2>NIJE!</h2>";
        }
    } else {
        echo "<script>alert(\"GRESKA!\")</script>";
    }
}

if (isset($_GET["obrisi"])) {
    if ($db->deleteArtikal($_GET["idArtikal"])) {
        $message = "<div>Uspešno obrisan artikal</div>";
    } else {
        $message = "<div>Neuspešno obrisan artikal</div>";
    }
}

if (isset($_POST["logout"])) {
    header("Location: login.php");
}

if (isset($_GET["grupisi"])) {
    $idKat = $_GET["idKategorija"];
    $rez = $db->getArtikliByKategorija($idKat);
}

if (isset($_POST["sort"])) {
    usort($rez, "cmp");
}
if (isset($_POST["sortCena"])) {
    usort($rez, "cmpCena");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/style.css">

    <title>Shop</title>
</head>

<body>
    <div class="header">
        <a href="home.php" class="logo"><img src="images/logo2.png" class="logoImg"></a>
        <div class="header-right">
            <form method="GET">

                <a class="active" href="home.php">Pocetna</a>
                <a href="?grupisi&idKategorija=1">Kopacke</a>
                <a href="?grupisi&idKategorija=2">Zastita</a>
                <a href="?grupisi&idKategorija=4">Lopte</a>
                <a href="?grupisi&idKategorija=5">Dresovi</a>
                <a href="?grupisi&idKategorija=6">Sorcevi</a>
            </form>
            <form method="POST">
                <button type="submit" name="logout" style="float: right; width: 20%;">Odjava</button>
            </form>
        </div>

    </div>

    <div class="wrap-collabsible">
        <input id="collapsible" class="toggle" type="checkbox">
        <label for="collapsible" class="lbl-toggle">Dodaj nov artikal</label>
        <div class="collapsible-content">
            <div class="content-inner">
                <form method="POST" action="home.php" enctype="multipart/form-data">
                    <label>Naziv artikla: </label>
                    <input type="text" name="nazivArtikla"> <br>
                    <label>Kategorija</label>
                    <select name="kategorijaSelect">
                        <?php
                        $kategorije = $db->getAllKategorije();
                        foreach ($kategorije as $k => $v) {
                            echo "<option value=\"{$v["idKategorija"]}\">{$v["naziv"]}</option>";
                        }
                        ?>
                    </select> <br>
                    <label>Cena: </label>
                    <input type="number" name="cenaArtikla"><br>
                    <label>Slika artikla:</label>
                    <input type="file" name="slika" id="slika"><br>
                    <input type="submit" name="unos" value="Dodaj artikal">
                </form>

            </div>
        </div>
    </div>

    <div class="title">
        <h1>PONUDA</h1>

        <form method="POST">
            <input type="submit" value="Sort po nazivu" name="sort">
            <input type="submit" value="Sort po ceni" name="sortCena">
        </form>
    </div>

    <div class="kontejner">
        <?php
        foreach ($rez as $r) {
            $kat = $db->getKategorijaById($r->getKategorija());
            echo $r->getHtmlAdmin($kat);
        }
        ?>

    </div>

</body>

</html>