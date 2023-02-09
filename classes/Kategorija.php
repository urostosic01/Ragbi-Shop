<?php
class Kategorija {
    
    private $idKategorija;
    private $naziv;

    public function __construct($idKategorija, $naziv) {
        $this->idKategorija = $idKategorija;
        $this->naziv = $naziv;
    }

    public function getNaziv() {
        return $this->naziv;
    }

    public function getIdKategorija() {
        return $this->idKategorija;
    }
}

?>

