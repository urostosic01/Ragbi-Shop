<?php
class Artikal{
    private $idArtikal;
    private $naziv;
    private $kategorija;
    private $cena;
    private $slika;

    public function __construct($idArtikal, $naziv, $kategorija, $slika, $cena) {
        $this->idArtikal = $idArtikal;
        $this->naziv = $naziv;
        $this->kategorija = $kategorija;
        $this->slika = $slika;
        $this->cena = $cena;
    }

    public function getNaziv() {
        return $this->naziv;
    }

    public function getIdArtikal() {
        return $this->idArtikal;
    }
    
    public function getKategorija(){
        return $this->kategorija;
    }

    public function getCena() {
        return $this->cena;
    }
    
    public function getSlika() {
        return $this->slika;
    }

    public function getHtmlAdmin($kat) {
        echo "<div class=\"card\">";
            echo    "<img src=\"images/$this->slika\" alt=\"slikaArtikla\" width=\"100%\">";
            echo    "<h1>". $this->naziv ."</h1>";
            echo    "<p>Kategorija: ". $kat["naziv"] ."</p>"; 
            echo    "<p class=\"price\">Cena:". $this->cena ."</p>";
            //echo    "<a href=\"?obrisi&idArtikal={$this->idArtikal}\"><p style=\"text-align: center;\">Obrisi</p></a>";
            echo    "<a href=\"?obrisi&idArtikal={$this->idArtikal}\"><img src=\"images/kanta.png\"></a>";            
        echo "</div>";
    }

    public function getHtmlUser($kat) {
        echo "<div class=\"card\">";
            echo    "<img src=\"images/$this->slika\" alt=\"slikaArtikla\" width=\"100%\">";
            echo    "<h1>". $this->naziv ."</h1>";
            echo    "<p>Kategorija: ". $kat["naziv"] ."</p>"; 
            echo    "<p class=\"price\">Cena:". $this->cena ."</p>";
            echo    "<a href=\"?dodaj&idArtikal={$this->idArtikal}\">Dodaj u korpu</a>";            
        echo "</div>";
    }
    public function getHtmlGuest($kat) {
        echo "<div class=\"card\">";
            echo    "<img src=\"images/$this->slika\" alt=\"slikaArtikla\" width=\"100%\">";
            echo    "<h1>". $this->naziv ."</h1>";
            echo    "<p>Kategorija: ". $kat["naziv"] ."</p>"; 
            echo    "<p class=\"price\">Cena:". $this->cena ."</p>";
                     
        echo "</div>";
    }
    
}

?>