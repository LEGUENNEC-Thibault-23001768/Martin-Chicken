<?php

use PHPUnit\Framework\TestCase;

class ConstantesTest extends TestCase
{
    public function testRepertoireRacine()
    {
        $expected = realpath(__DIR__ . '/../');
        $this->assertEquals($expected, Constantes::repertoireRacine());
    }

    public function testRepertoireVues()
    {
        $expected = realpath(__DIR__ . '/../Vues/');
        $this->assertEquals($expected, Constantes::repertoireVues());
    }

    public function testRepertoireModele()
    {
        $expected = realpath(__DIR__ . '/../Modele/');
        $this->assertEquals($expected, Constantes::repertoireModele());
    }
}
?>
