<?php
require_once "classes/db_utils.php";
require_once "classes/funkcije.php";
session_start();

//POCETNA STRANICA ZA GOSTA
//moze da pregleda i sortira artikle

$db = new Database();
$rez = $db->getAllArtikal2();


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
    <link rel="stylesheet" type="text/css" href="css/style.css" />

    <title>Shop</title>
</head>

<body>
    <div class="header">
        <a href="home_guest.php" class="logo"><img src="images/logo2.png" class="logoImg"></a>
        <div class="header-right">
            <form method="GET">

                <a class="active" href="home_guest.php">Pocetna</a>
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
            echo $r->getHtmlGuest($kat);
        }
        ?>
    </div>

</body>

</html>