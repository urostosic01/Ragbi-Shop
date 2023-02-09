<?php
require_once "classes/db_utils.php";
require_once "classes/funkcije.php";
session_start();

//POCETNA STRANICA ZA REGISTROVANOG KORISNIKA
//moze da pregleda, sortira i dodaje artikle u korpu

$db = new Database();


$rez = $db->getAllArtikal2();


if (isset($_SESSION["items"])) {
    $items = $_SESSION["items"];
} else {
    $items = array();
}

if (isset($_POST["logout"])) {
    setcookie("username", "", time() - 3600);
    header("Location: login.php");
}

if (isset($_GET["dodaj"])) {
    if (!isset($_SESSION["items"])) {
        $_SESSION["items"] = array();
    }
    $_SESSION["items"][] = htmlspecialchars($_GET["idArtikal"]);
    header("Location: home_user.php");
}

if (isset($_GET["obrisi"])) { //brisanje pojedinacnog artikla iz korpe
    $key = array_search($_GET["idArtikal"], $_SESSION["items"]);
    if ($key !== false)
        unset($_SESSION["items"][$key]);
    $_SESSION["items"] = array_values($_SESSION["items"]);
    header("Location: home_user.php");
}

if (isset($_GET["ukloniSve"])) {
    setcookie("PHPSESSID", "", time() - 1000, "/");
    session_destroy();
    header("Location: home_user.php");
}
if(isset($_GET["grupisi"])){
    $idKat = $_GET["idKategorija"];
    $rez = $db -> getArtikliByKategorija($idKat);
}


if (isset($_POST["sort"])) {
    usort($rez, "cmp"); //komparatori se nalaze u funkcije.php fajlu, 
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

        <a href="home_user.php" class="logo"><img src="images/logo2.png" class="logoImg"></a>

        <div class="header-right">
            <form method="GET">

                <a class="active" href="home_user.php">Pocetna</a>
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
        <label for="collapsible" class="lbl-toggle">Korpa</label>
        <div class="collapsible-content">
            <div class="content-inner">
                <p>Dobrodosli <?php echo $_COOKIE["korisnik"] . "(reg. br: " . $_COOKIE["idKorisnik"] . ")"; ?></p>
                <p>Stavke u korpi:</p>
                <?php
                foreach ($items as $item) {
                    $stavka = $db->getArtikalById($item);
                    echo "<br>";
                    echo $stavka["naziv"];
                    echo " <a href=\"?obrisi&idArtikal={$stavka["idArtikal"]}\">Obrisi</a>";
                    echo "<br>";
                }
                ?>
                <br>
                <a href="?ukloniSve"><button>Obriši sve iz korpe</button></a>

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
    <form method="POST">
        <div class="kontejner">
            <?php
            foreach ($rez as $r) {
                $kat = $db->getKategorijaById($r->getKategorija());
                echo $r->getHtmlUser($kat);
            }
            ?>
        </div>
    </form>


</body>

</html>