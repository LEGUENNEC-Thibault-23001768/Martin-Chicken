<?php

use PHPUnit\Framework\TestCase;

class TenracModelTest extends TestCase
{
    protected $connexionMock;

    protected function setUp(): void
    {
        // Mock de la classe Connexion pour éviter les requêtes réelles à la base de données
        $this->connexionMock = $this->createMock(Connexion::class);
    }

    public function testAjouterTenrac()
    {
        $tenracData = [
            'code_personnel' => 'CP12345',
            'nom' => 'Jean Dupont',
            'email' => 'jean.dupont@example.com',
            'numero' => '0606060606',
            'adresse' => '123 Rue de la Paix',
            'grade' => 'Chevalier',
            'rang' => 'Novice',
            'titre' => 'Philanthrope',
            'dignite' => 'Maître',
            'structure_id' => 1
        ];

        // Simuler l'insertion d'un tenrac avec succès
        $this->connexionMock->expects($this->once())
            ->method('execute')
            ->with($this->anything())
            ->willReturn(true);

        $this->connexionMock->expects($this->once())
            ->method('lastInsertId')
            ->willReturn(1);

        $tenracId = TenracModel::ajouterTenrac($tenracData);
        $this->assertEquals(1, $tenracId, 'Le Tenrac devrait être ajouté avec succès et retourner un ID.');
    }

    public function testModifierTenrac()
    {
        $tenracData = [
            'code_personnel' => 'CP12345',
            'nom' => 'Jean Dupont Modifié',
            'email' => 'jean.dupont@example.com',
            'numero' => '0606060606',
            'adresse' => '123 Rue de la Paix',
            'grade' => 'Chevalier',
            'rang' => 'Novice',
            'titre' => 'Philanthrope',
            'dignite' => 'Maître',
            'structure_id' => 1
        ];

        // Simuler la modification d'un Tenrac
        $this->connexionMock->expects($this->once())
            ->method('execute')
            ->with($this->anything())
            ->willReturn(true);

        $result = TenracModel::modifierTenrac(1, $tenracData);
        $this->assertTrue($result, 'La modification du Tenrac devrait réussir.');
    }

    public function testSupprimerTenrac()
    {
        // Simuler la suppression d'un Tenrac
        $this->connexionMock->expects($this->once())
            ->method('execute')
            ->with($this->anything())
            ->willReturn(true);

        $result = TenracModel::supprimerTenrac(1);
        $this->assertTrue($result, 'La suppression du Tenrac devrait réussir.');
    }

    public function testListerTenracs()
    {
        // Simuler la liste des Tenracs
        $this->connexionMock->expects($this->once())
            ->method('execute')
            ->with($this->anything())
            ->willReturn([
                ['Id' => 1, 'Nom' => 'Jean Dupont', 'Structure_Nom' => 'Ordre des Tenracs'],
                ['Id' => 2, 'Nom' => 'Marie Dubois', 'Structure_Nom' => 'Club des Gourmets']
            ]);

        $tenracs = TenracModel::listerTenracs();
        $this->assertCount(2, $tenracs, 'Il devrait y avoir deux Tenracs dans la liste.');
    }

    public function testObtenirTenrac()
    {
        // Simuler l'obtention d'un Tenrac spécifique
        $this->connexionMock->expects($this->once())
            ->method('execute')
            ->with($this->anything())
            ->willReturn([
                ['Id' => 1, 'Nom' => 'Jean Dupont', 'Structure_Nom' => 'Ordre des Tenracs']
            ]);

        $tenrac = TenracModel::obtenirTenrac(1);
        $this->assertEquals('Jean Dupont', $tenrac['Nom'], 'Le Tenrac récupéré devrait être Jean Dupont.');
    }
}
