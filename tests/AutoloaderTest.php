<?php

use PHPUnit\Framework\TestCase;

class AutoloaderTest extends TestCase
{
    public function testChargerClassesNoyau()
    {
        $this->assertTrue(class_exists('Connexion', true), 'La classe Connexion devrait être chargée');
    }

    public function testChargerClassesModele()
    {
        $this->assertTrue(class_exists('RepasModel', true), 'La classe RepasModel devrait être chargée');
    }

    public function testChargerClassesVue()
    {
        $this->assertTrue(class_exists('Vue', true), 'La classe Vue devrait être chargée');
    }

    public function testChargerClassesControleur()
    {
        $this->assertTrue(class_exists('AccueilController', true), 'La classe AccueilController devrait être chargée');
    }
}
?>
