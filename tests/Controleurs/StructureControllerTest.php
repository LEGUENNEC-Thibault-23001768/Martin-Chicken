<?php

use PHPUnit\Framework\TestCase;

class StructureControllerTest extends TestCase
{
    protected function setUp(): void
    {
        // Inclure les dépendances nécessaires
        require_once __DIR__ . '/../modules/Noyau/Vue.php';
        require_once __DIR__ . '/../modules/Modele/AuthModel.php';
        require_once __DIR__ . '/../modules/Modele/StructureModel.php';
        require_once __DIR__ . '/../modules/Controleurs/StructureController.php';

        // Simuler une session PHP
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Simuler un utilisateur connecté
        $_SESSION['user_id'] = 1;
        $_SESSION['csrf_token'] = 'valid_token';
    }

    public function testDefautAction()
    {
        // Test de la méthode defautAction qui appelle listerAction()
        $controller = new StructureController();

        // Capture de l'affichage
        ob_start();
        $controller->defautAction();
        $output = ob_get_clean();

        // Vérifier que la vue de la liste des structures est affichée
        $this->assertStringContainsString('gestion/lister', $output, 'La vue de gestion des structures doit être affichée.');
    }

    public function testAjouterActionWithValidData()
    {
        // Simuler une requête POST avec des données valides
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['csrf_token'] = 'valid_token';
        $_POST['type'] = 'Club';
        $_POST['nom'] = 'Structure Test';
        $_POST['adresse'] = '123 Rue Test';

        // Mock des méthodes du modèle
        $structureModelMock = $this->createMock(StructureModel::class);
        $structureModelMock->method('ajouterStructure')->willReturn(1);

        $controller = new StructureController();

        // Capture de la redirection
        ob_start();
        $controller->ajouterAction();
        $output = ob_get_clean();

        // Vérifier que l'utilisateur est redirigé après l'ajout de la structure
        $this->assertStringContainsString('Location: index.php?ctrl=Login', $output, 'L\'utilisateur doit être redirigé après l\'ajout de la structure.');
    }

    public function testAjouterActionWithMissingData()
    {
        // Simuler une requête POST avec des données manquantes
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['csrf_token'] = 'valid_token';
        $_POST['nom'] = '';  // Nom manquant

        $controller = new StructureController();

        // Capture de l'affichage avec erreur
        ob_start();
        $controller->ajouterAction();
        $output = ob_get_clean();

        // Vérifier que l'erreur est bien affichée
        $this->assertStringContainsString('Veuillez remplir tous les champs', $output, 'Un message d\'erreur doit être affiché lorsque des champs sont manquants.');
    }

    public function testModifierActionWithValidData()
    {
        // Simuler une requête POST avec des données valides pour modifier une structure
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['csrf_token'] = 'valid_token';
        $_POST['id'] = 1;
        $_POST['nom'] = 'Structure Modifiée';
        $_POST['adresse'] = '456 Rue Modifiée';

        // Mock des méthodes du modèle
        $structureModelMock = $this->createMock(StructureModel::class);
        $structureModelMock->method('obtenirStructure')->willReturn(['id' => 1, 'nom' => 'Structure Test', 'adresse' => '123 Rue Test']);
        $structureModelMock->method('modifierStructure')->willReturn(true);

        $controller = new StructureController();

        // Capture de l'affichage
        ob_start();
        $controller->modifierAction();
        $output = ob_get_clean();

        // Vérifier que la vue de modification est affichée
        $this->assertStringContainsString('gestion/modifier', $output, 'La vue de modification de la structure doit être affichée.');
    }

    public function testSupprimerAction()
    {
        // Simuler une requête GET pour supprimer une structure
        $_GET['id'] = 1;

        // Mock de la méthode du modèle
        $structureModelMock = $this->createMock(StructureModel::class);
        $structureModelMock->method('supprimerStructure')->willReturn(true);

        $controller = new StructureController();

        // Capture de la redirection après suppression
        ob_start();
        $controller->supprimerAction();
        $output = ob_get_clean();

        // Vérifier que l'utilisateur est redirigé après la suppression
        $this->assertStringContainsString('Location: index.php?ctrl=Login', $output, 'L\'utilisateur doit être redirigé après la suppression de la structure.');
    }

    public function testListerAction()
    {
        // Simuler une requête pour lister les structures
        $controller = new StructureController();

        // Capture de l'affichage
        ob_start();
        $controller->listerAction();
        $output = ob_get_clean();

        // Vérifier que la vue de la liste des structures est affichée
        $this->assertStringContainsString('gestion/lister', $output, 'La vue de la liste des structures doit être affichée.');
    }
}
