<?php

use PHPUnit\Framework\TestCase;

class ControleurTest extends TestCase
{
    public function testGetUrlDecortiqueDefault()
    {
        $controleur = new Controleur(null, null);
        $this->assertEquals('AccueilController', $controleur->getUrlDecortique()['controleur']);
        $this->assertEquals('defautAction', $controleur->getUrlDecortique()['action']);
    }

    public function testGetUrlDecortiqueCustom()
    {
        $controleur = new Controleur('repas', 'afficher');
        $this->assertEquals('RepasController', $controleur->getUrlDecortique()['controleur']);
        $this->assertEquals('afficherAction', $controleur->getUrlDecortique()['action']);
    }
}
?>
