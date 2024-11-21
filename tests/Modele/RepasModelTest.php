<?php

use PHPUnit\Framework\TestCase;

class RepasModelTest extends TestCase
{
    protected $connexionMock;

    protected function setUp(): void
    {
        // Mock de la classe Connexion pour éviter les requêtes réelles à la base de données
        $this->connexionMock = $this->createMock(Connexion::class);
    }

    public function testAjouterRepas()
    {
        // Simuler l'ajout d'un repas avec succès
        $this->connexionMock->expects($this->once())
            ->method('execute')
            ->with($this->anything())
            ->willReturn(true);

        $this->connexionMock->expects($this->once())
            ->method('lastInsertId')
            ->willReturn(1);

        $repasId = RepasModel::ajouterRepas('Dîner Raclette', '2023-09-30', 'Paris');
        $this->assertEquals(1, $repasId, 'Le repas devrait être ajouté avec succès et retourner un ID.');
    }

    public function testModifierRepas()
    {
        // Simuler la modification d'un repas
        $this->connexionMock->expects($this->once())
            ->method('execute')
            ->with($this->anything())
            ->willReturn(true);

        $result = RepasModel::modifierRepas(1, 'Déjeuner Raclette', '2023-09-30', 'Lyon');
        $this->assertTrue($result, 'La modification du repas devrait réussir.');
    }

    public function testSupprimerRepas()
    {
        // Simuler la suppression d'un repas
        $this->connexionMock->expects($this->once())
            ->method('execute')
            ->with($this->anything())
            ->willReturn(true);

        $result = RepasModel::supprimerRepas(1);
        $this->assertTrue($result, 'La suppression du repas devrait réussir.');
    }

    public function testListerRepas()
    {
        // Simuler la liste des repas
        $this->connexionMock->expects($this->once())
            ->method('execute')
            ->with($this->anything())
            ->willReturn([
                ['Id' => 1, 'Nom' => 'Dîner Raclette', 'Date' => '2023-09-30', 'Adresse' => 'Paris'],
                ['Id' => 2, 'Nom' => 'Déjeuner Fondue', 'Date' => '2023-10-01', 'Adresse' => 'Lyon']
            ]);

        $repas = RepasModel::listerRepas();
        $this->assertCount(2, $repas, 'Il devrait y avoir deux repas dans la liste.');
    }

    public function testObtenirRepas()
    {
        // Simuler l'obtention d'un repas spécifique
        $this->connexionMock->expects($this->once())
            ->method('execute')
            ->with($this->anything())
            ->willReturn([
                ['Id' => 1, 'Nom' => 'Dîner Raclette', 'Date' => '2023-09-30', 'Adresse' => 'Paris']
            ]);

        $repas = RepasModel::obtenirRepas(1);
        $this->assertEquals('Dîner Raclette', $repas['Nom'], 'Le repas récupéré devrait être le Dîner Raclette.');
    }

    public function testAssocierPlats()
    {
        // Simuler l'association de plats à un repas
        $this->connexionMock->expects($this->exactly(2)) // Deux plats à associer
            ->method('execute')
            ->with($this->anything())
            ->willReturn(true);

        $result = RepasModel::associerPlats(1, [2, 3]);
        $this->assertTrue($result, 'L\'association des plats au repas devrait réussir.');
    }

    public function testObtenirPlatsRepas()
    {
        // Simuler l'obtention des plats associés à un repas
        $this->connexionMock->expects($this->once())
            ->method('execute')
            ->with($this->anything())
            ->willReturn([
                ['Id' => 2, 'Nom' => 'Raclette', 'Presence' => true],
                ['Id' => 3, 'Nom' => 'Fondue', 'Presence' => false]
            ]);

        $plats = RepasModel::obtenirPlatsRepas(1);
        $this->assertCount(2, $plats, 'Il devrait y avoir deux plats associés au repas.');
    }

    public function testMettreAJourPlats()
    {
        // Simuler la mise à jour des plats associés à un repas
        $this->connexionMock->expects($this->once())
            ->method('execute')
            ->with($this->anything())
            ->willReturn(true);

        $this->connexionMock->expects($this->exactly(2)) // Deux nouveaux plats
            ->method('execute')
            ->with($this->anything())
            ->willReturn(true);

        $result = RepasModel::mettreAJourPlats(1, [2, 3]);
        $this->assertTrue($result, 'Les plats du repas devraient être mis à jour avec succès.');
    }
}
