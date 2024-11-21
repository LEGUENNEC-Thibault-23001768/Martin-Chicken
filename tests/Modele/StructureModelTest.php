<?php

use PHPUnit\Framework\TestCase;

class StructureModelTest extends TestCase
{
    protected $connexionMock;

    protected function setUp(): void
    {
        // Mock de la classe Connexion pour éviter les requêtes réelles à la base de données
        $this->connexionMock = $this->createMock(Connexion::class);
    }

    public function testAjouterStructure()
    {
        // Simuler l'ajout d'une structure avec succès
        $this->connexionMock->expects($this->once())
            ->method('execute')
            ->with($this->anything())
            ->willReturn(true);

        $this->connexionMock->expects($this->once())
            ->method('lastInsertId')
            ->willReturn(1);

        $structureId = StructureModel::ajouterStructure('Ordre', 'Ordre des Tenracs', '123 Rue de la Raclette');
        $this->assertEquals(1, $structureId, 'La structure devrait être ajoutée avec succès et retourner un ID.');
    }

    public function testModifierStructure()
    {
        // Simuler la modification d'une structure
        $this->connexionMock->expects($this->once())
            ->method('execute')
            ->with($this->anything())
            ->willReturn(true);

        $result = StructureModel::modifierStructure(1, 'Ordre des Tenracs Modifié', '456 Rue de la Fondue');
        $this->assertTrue($result, 'La modification de la structure devrait réussir.');
    }

    public function testSupprimerStructure()
    {
        // Simuler la suppression d'une structure
        $this->connexionMock->expects($this->once())
            ->method('execute')
            ->with($this->anything())
            ->willReturn(true);

        $result = StructureModel::supprimerStructure(1);
        $this->assertTrue($result, 'La suppression de la structure devrait réussir.');
    }

    public function testListerStructures()
    {
        // Simuler la liste des structures
        $this->connexionMock->expects($this->once())
            ->method('execute')
            ->with($this->anything())
            ->willReturn([
                ['Id' => 1, 'Nom' => 'Ordre des Tenracs', 'Adresse' => '123 Rue de la Raclette'],
                ['Id' => 2, 'Nom' => 'Club Raclette', 'Adresse' => '456 Rue de la Fondue']
            ]);

        $structures = StructureModel::listerStructures();
        $this->assertCount(2, $structures, 'Il devrait y avoir deux structures dans la liste.');
    }

    public function testObtenirStructure()
    {
        // Simuler l'obtention d'une structure spécifique
        $this->connexionMock->expects($this->once())
            ->method('execute')
            ->with($this->anything())
            ->willReturn([
                ['Id' => 1, 'Nom' => 'Ordre des Tenracs', 'Adresse' => '123 Rue de la Raclette']
            ]);

        $structure = StructureModel::obtenirStructure(1);
        $this->assertEquals('Ordre des Tenracs', $structure['Nom'], 'La structure récupérée devrait être l\'Ordre des Tenracs.');
    }

    public function testListerClubs()
    {
        // Simuler la liste des clubs
        $this->connexionMock->expects($this->once())
            ->method('execute')
            ->with($this->anything())
            ->willReturn([
                ['Id' => 2, 'Nom' => 'Club Raclette', 'Adresse' => '456 Rue de la Fondue', 'Type' => 'Club']
            ]);

        $clubs = StructureModel::listerClubs();
        $this->assertCount(1, $clubs, 'Il devrait y avoir un club dans la liste.');
    }

    public function testObtenirOrdre()
    {
        // Simuler l'obtention de l'ordre
        $this->connexionMock->expects($this->once())
            ->method('execute')
            ->with($this->anything())
            ->willReturn([
                ['Id' => 1, 'Nom' => 'Ordre des Tenracs', 'Adresse' => '123 Rue de la Raclette', 'Type' => 'Ordre']
            ]);

        $ordre = StructureModel::obtenirOrdre();
        $this->assertEquals('Ordre des Tenracs', $ordre['Nom'], 'La structure récupérée devrait être l\'Ordre des Tenracs.');
    }
}
