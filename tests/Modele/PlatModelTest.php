<?php

use PHPUnit\Framework\TestCase;

class PlatModelTest extends TestCase
{
    protected $connexionMock;

    protected function setUp(): void
    {
        // Créer un mock de la classe Connexion pour éviter d'effectuer de vraies requêtes à la base de données
        $this->connexionMock = $this->createMock(Connexion::class);
    }

    public function testAjouterPlat()
    {
        // Simuler le retour de la méthode Connexion::lastInsertId pour retourner un ID simulé
        $this->connexionMock->expects($this->once())
            ->method('execute')
            ->with($this->anything())
            ->willReturn(true);

        $this->connexionMock->expects($this->once())
            ->method('lastInsertId')
            ->willReturn(1);

        // Test de l'ajout d'un plat
        $platId = PlatModel::ajouterPlat('Raclette', true);
        $this->assertEquals(1, $platId, 'Le plat devrait être ajouté avec succès et retourner un ID.');
    }

    public function testModifierPlat()
    {
        // Simuler la modification d'un plat
        $this->connexionMock->expects($this->once())
            ->method('execute')
            ->with($this->anything())
            ->willReturn(true);

        $result = PlatModel::modifierPlat(1, 'Raclette Modifiée');
        $this->assertTrue($result, 'La modification du plat devrait réussir.');
    }

    public function testSupprimerPlat()
    {
        // Simuler la suppression d'un plat
        $this->connexionMock->expects($this->once())
            ->method('execute')
            ->with($this->anything())
            ->willReturn(true);

        $result = PlatModel::supprimerPlat(1);
        $this->assertTrue($result, 'La suppression du plat devrait réussir.');
    }

    public function testAssocierIngredients()
    {
        // Simuler l'association des ingrédients
        $this->connexionMock->expects($this->exactly(2)) // Deux ingrédients
            ->method('execute')
            ->with($this->anything())
            ->willReturn(true);

        $result = PlatModel::associerIngredients(1, [2, 3]);
        $this->assertTrue($result, 'L\'association des ingrédients devrait réussir.');
    }

    public function testAssocierSauces()
    {
        // Simuler l'association des sauces
        $this->connexionMock->expects($this->exactly(2)) // Deux sauces
            ->method('execute')
            ->with($this->anything())
            ->willReturn(true);

        $result = PlatModel::associerSauces(1, [4, 5]);
        $this->assertTrue($result, 'L\'association des sauces devrait réussir.');
    }

    public function testListerPlats()
    {
        // Simuler la liste des plats
        $this->connexionMock->expects($this->once())
            ->method('execute')
            ->with($this->anything())
            ->willReturn([
                ['Id' => 1, 'Nom' => 'Raclette', 'Presence' => true],
                ['Id' => 2, 'Nom' => 'Fondue', 'Presence' => false]
            ]);

        $plats = PlatModel::listerPlats();
        $this->assertCount(2, $plats, 'Il devrait y avoir deux plats dans la liste.');
    }

    public function testObtenirPlat()
    {
        // Simuler l'obtention d'un plat spécifique
        $this->connexionMock->expects($this->once())
            ->method('execute')
            ->with($this->anything())
            ->willReturn([
                ['Id' => 1, 'Nom' => 'Raclette', 'Presence' => true]
            ]);

        $plat = PlatModel::obtenirPlat(1);
        $this->assertEquals('Raclette', $plat['Nom'], 'Le plat récupéré devrait être la Raclette.');
    }

    public function testMettreAJourIngredients()
    {
        // Simuler la mise à jour des ingrédients
        $this->connexionMock->expects($this->once())
            ->method('execute')
            ->with($this->anything())
            ->willReturn(true);

        // Simuler l'association des nouveaux ingrédients
        $this->connexionMock->expects($this->exactly(2))
            ->method('execute')
            ->with($this->anything())
            ->willReturn(true);

        $result = PlatModel::mettreAJourIngredients(1, [2, 3]);
        $this->assertTrue($result, 'Les ingrédients du plat devraient être mis à jour avec succès.');
    }

    public function testMettreAJourSauces()
    {
        // Simuler la mise à jour des sauces
        $this->connexionMock->expects($this->once())
            ->method('execute')
            ->with($this->anything())
            ->willReturn(true);

        // Simuler l'association des nouvelles sauces
        $this->connexionMock->expects($this->exactly(2))
            ->method('execute')
            ->with($this->anything())
            ->willReturn(true);

        $result = PlatModel::mettreAJourSauces(1, [4, 5]);
        $this->assertTrue($result, 'Les sauces du plat devraient être mises à jour avec succès.');
    }
}

