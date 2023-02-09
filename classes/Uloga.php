<?php
class Uloga{
    private $idUloga;
    private $naziv;

    public function __construct($idUloga, $naziv) {
        $this->idUloga = $idUloga;
        $this->naziv = $naziv;
    }

    public function getNaziv() {
        return $this->naziv;
    }

    public function getId() {
        return $this->idUloga;
    }
}

?>

