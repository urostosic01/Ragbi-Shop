<?php
class Korisnik {
    private $idKorisnik;
    private $ime;
    private $prezime;
    private $email;
    private $korIme;
    private $lozinka;
    private $slika;
    private $idUloga;

    public function __construct($idKorisnik, $ime, $prezime, $email, $korIme, $lozinka, $slika, $idUloga) {
        $this->idKorisnik = $idKorisnik;
        $this->ime = $ime;
        $this->prezime = $prezime;
        $this->email = $email;
        $this->korIme = $korIme;
        $this->lozinka = $lozinka;
        $this->slika = $slika;
        $this->idUloga = $idUloga;
    }

    public function getIdKorisnik() {
        return $this->idKorisnik;
    }
    public function getIme() {
        return $this->ime;
    }
    public function getPrezime() {
        return $this->prezime;
    }
    public function getEmail() {
        return $this->email;
    }
    public function getKorisnickoIme() {
        return $this->korIme;
    }
    public function getLozinka() {
        return $this->lozinka;
    }
    public function getSlika(){
        return $this->slika;
    }
    public function getIdUloga() {
        return $this->idUloga;
    }

    
}
?>