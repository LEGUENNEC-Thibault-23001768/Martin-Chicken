<?php

use PHPUnit\Framework\TestCase;

class ControleurTest extends TestCase
{
    // Test du constructeur avec contrôleur et action par défaut
    public function testConstructDefaultValues()
    {
        $controleur = new Controleur(null, null);
        $this->assertEquals('AccueilController', $this->getPrivateProperty($controleur, '_A_urlDecortique')['controleur']);
        $this->assertEquals('defaultAction', $this->getPrivateProperty($controleur, '_A_urlDecortique')['action']);
    }

    // Test si le contrôleur et l'action fournis sont bien définis
    public function testConstructWithValues()
    {
        $controleur = new Controleur('test', 'view');
        $this->assertEquals('TestController', $this->getPrivateProperty($controleur, '_A_urlDecortique')['controleur']);
        $this->assertEquals('viewAction', $this->getPrivateProperty($controleur, '_A_urlDecortique')['action']);
    }

    // Utilitaire pour accéder aux propriétés privées
    private function getPrivateProperty($object, $property)
    {
        $reflection = new ReflectionClass($object);
        $property = $reflection->getProperty($property);
        $property->setAccessible(true);
        return $property->getValue($object);
    }
}
