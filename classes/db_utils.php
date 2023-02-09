<?php
require_once("constants.php");
require_once("Kategorija.php");
require_once("Artikal.php");
require_once("Uloga.php");
require_once("Korisnik.php");


class Database { 

    private $conn;
    private $hashing_salt = "dsaf7493^&$(#@Kjh";

    public function __construct($configFile = "config.ini") {
        if($config = parse_ini_file($configFile)) {
            $host = $config["host"];
            $database = $config["database"];
            $user = $config["user"];
            $password = $config["password"];
            $this->conn = new PDO("mysql:host=$host;dbname=$database", $user, $password);
        }
        else
            exit("Missing configuration file.");
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function __destruct() {
        $this->conn = null;
    }

    // public function getAllArtikal() {
    //     $result = array();
    //     $sql = "SELECT * FROM ".TBL_ARTIKAL;
    //     try {
    //         $query_result = $this->conn->query($sql);
    //         foreach ($query_result as $q) {
    //             $result[] = $q;
    //         }
    //     } catch (PDOException $e) {
    //         //echo $e->getMessage();
    //     }
    //     return $result;
    // }


    public function getAllArtikal2() {
        $result = array();
        $sql = "SELECT * FROM ".TBL_ARTIKAL;
        try{
            $query_result = $this->conn->query($sql);
            foreach ($query_result as $q) {
                $result[] = new Artikal($q[COL_ARTIKAL_ID], $q[COL_ARTIKAL_NAZIV], $q[COL_ARTIKAL_KATEGORIJA_ID], 
                $q[COL_ARTIKAL_SLIKA], $q[COL_ARTIKAL_CENA]);
            }
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
        return $result;
    }


    public function getAllKategorije() {
        $result = array();
        $sql = "SELECT * FROM ".TBL_KATEGORIJA;
        try {
            $query_result = $this->conn->query($sql);
            foreach ($query_result as $q) {
                $result[] = $q;
            }
        } catch (PDOException $e) {
            //echo $e->getMessage();
        }
        return $result;
    }

    public function insertArtikal($naziv, $kategorija, $cena, $slika) {
        $sql = "INSERT INTO ".TBL_ARTIKAL." (".COL_ARTIKAL_NAZIV.", ".COL_ARTIKAL_KATEGORIJA_ID.
                                            ",". COL_ARTIKAL_CENA . "," . COL_ARTIKAL_SLIKA . 
                                            ") VALUES (:naziv, :kategorija, :cena, :slika);";
	    	try {
				$st = $this->conn->prepare($sql);
				$st->bindValue(":naziv", $naziv, PDO::PARAM_STR);
				$st->bindValue(":kategorija", $kategorija, PDO::PARAM_INT);
                $st->bindValue(":cena", $cena, PDO::PARAM_INT);
                $st->bindValue(":slika", $slika, PDO::PARAM_STR);
				$st->execute();
			} catch (PDOException $e) {
				echo $e->getMessage();
				return false;
			}
			return true;
    }


    public function deleteArtikal($id) {
        $sql = "DELETE FROM ".TBL_ARTIKAL." WHERE ".COL_ARTIKAL_ID." = :idArtikal";
        try {
            $st = $this->conn->prepare($sql);
            $st->bindValue(":idArtikal", $id);
            $st->execute();
        } catch (PDOException $e) {
            //echo $e->getMessage();
            return false;
        }
        return true;
    }

    public function loginProvera($korIme, $lozinka) {
        $hashLozinka = crypt($lozinka, $this->hashing_salt);

        $sql = "SELECT * FROM " . TBL_KORISNIK . " WHERE " . COL_KORISNIK_KORISNICKO_IME . "=:korIme and " 
                                                            . COL_KORISNIK_LOZNIKA . "=:lozinka";
        try{
            $st = $this->conn->prepare($sql);
            $st->bindValue("korIme", $korIme, PDO::PARAM_STR);
            $st->bindValue("lozinka", $hashLozinka, PDO::PARAM_STR);
            $st->execute();
            return $st->fetch();
        } catch (PDOException $e){
            echo $e;
            return null;
        }
    }

    public function getKategorijaById($id) {
        $sql = "SELECT * FROM " . TBL_KATEGORIJA . " WHERE " . COL_KATEGORIJA_ID . "=:id";
        try{
            $st = $this->conn->prepare($sql);
            $st->bindValue("id", $id, PDO::PARAM_INT);
            $st->execute();
            return $st->fetch();
        } catch (PDOException $e){
            echo $e;
            return null;
        }
    }

    public function getArtikalById($id) {
        $sql = "SELECT * FROM " . TBL_ARTIKAL . " WHERE " . COL_ARTIKAL_ID . "=:id";
        try{
            $st = $this->conn->prepare($sql);
            $st->bindValue("id", $id, PDO::PARAM_INT);
            $st->execute();
            return $st->fetch();
        } catch (PDOException $e){
            echo $e;
            return null;
        }
    }

    public function getArtikliByKategorija($idKat) {
        $result = array();
        $sql = "SELECT * FROM ".TBL_ARTIKAL." WHERE Kategorija_idKategorija = $idKat;";
        try{
            $query_result = $this->conn->query($sql);
            foreach ($query_result as $q) {
                $result[] = new Artikal($q[COL_ARTIKAL_ID], $q[COL_ARTIKAL_NAZIV], $q[COL_ARTIKAL_KATEGORIJA_ID], 
                $q[COL_ARTIKAL_SLIKA], $q[COL_ARTIKAL_CENA]);
            }
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
        return $result;
    }

    public function insertKorisnik($ime, $prezime, $email, $korIme, $lozinka, $slika) {
        $hashLozinka = crypt($lozinka, $this->hashing_salt);

        $sql = "INSERT INTO ".TBL_KORISNIK." (".COL_KORISNIK_IME.", ".COL_KORISNIK_PREZIME.
                                            ",". COL_KORISNIK_EMAIL . "," . COL_KORISNIK_KORISNICKO_IME . 
                                            "," . COL_KORISNIK_LOZNIKA . "," . COL_KORISNIK_SLIKA . "," . COL_KORISNIK_ULOGA_ID . 
                                            ") VALUES (:ime, :prezime, :email, :korIme, :lozinka, :slika, :idUloga);";
	    	try {
				$st = $this->conn->prepare($sql);
				$st->bindValue(":ime", $ime, PDO::PARAM_STR);
				$st->bindValue(":prezime", $prezime, PDO::PARAM_STR);
                $st->bindValue(":email", $email, PDO::PARAM_STR);
                $st->bindValue(":korIme", $korIme, PDO::PARAM_STR);
				$st->bindValue(":lozinka", $hashLozinka, PDO::PARAM_STR);
                $st->bindValue(":slika", $slika, PDO::PARAM_STR);
				$st->bindValue(":idUloga", 2, PDO::PARAM_INT);
				$st->execute();
			} catch (PDOException $e) {
				echo $e->getMessage();
				return false;
			}
			return true;
    }


}

?>