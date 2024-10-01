<?php

use PHPUnit\Framework\TestCase;

class TenracControllerTest extends TestCase
{
    protected function setUp(): void
    {
        // Inclure les dépendances nécessaires
        require_once __DIR__ . '/../modules/Noyau/Vue.php';
        require_once __DIR__ . '/../modules/Modele/AuthModel.php';
        require_once __DIR__ . '/../modules/Modele/TenracModel.php';
        require_once __DIR__ . '/../modules/Modele/StructureModel.php';
        require_once __DIR__ . '/../modules/Controleurs/TenracController.php';

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
        $controller = new TenracController();

        // Capture de l'affichage
        ob_start();
        $controller->defautAction();
        $output = ob_get_clean();

        // Vérifier que la vue de la liste des Tenracs est affichée
        $this->assertStringContainsString('gestion/lister', $output, 'La vue de gestion des Tenracs doit être affichée.');
    }

    public function testAjouterActionWithValidData()
    {
        // Simuler une requête POST avec des données valides
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['csrf_token'] = 'valid_token';
        $_POST['code_personnel'] = 'CP001';
        $_POST['nom'] = 'Tenrac Test';
        $_POST['email'] = 'test@example.com';
        $_POST['numero'] = '0123456789';
        $_POST['adresse'] = '123 Rue Test';
        $_POST['grade'] = 'Chevalier';
        $_POST['rang'] = 'Novice';
        $_POST['titre'] = 'Philanthrope';
        $_POST['dignite'] = 'Maître';
        $_POST['structure_id'] = 1;

        // Mock des méthodes du modèle
        $tenracModelMock = $this->createMock(TenracModel::class);
        $tenracModelMock->method('ajouterTenrac')->willReturn(1);

        $controller = new TenracController();

        // Capture de la redirection
        ob_start();
        $controller->ajouterAction();
        $output = ob_get_clean();

        // Vérifier que l'utilisateur est redirigé après l'ajout du Tenrac
        $this->assertStringContainsString('Location: index.php?ctrl=Login', $output, 'L\'utilisateur doit être redirigé après l\'ajout du Tenrac.');
    }

    public function testAjouterActionWithMissingData()
    {
        // Simuler une requête POST avec des données manquantes
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['csrf_token'] = 'valid_token';
        $_POST['nom'] = '';  // Nom manquant

        $controller = new TenracController();

        // Capture de l'affichage avec erreur
        ob_start();
        $controller->ajouterAction();
        $output = ob_get_clean();

        // Vérifier que l'erreur est bien affichée
        $this->assertStringContainsString('Veuillez remplir tous les champs obligatoires', $output, 'Un message d\'erreur doit être affiché lorsque des champs sont manquants.');
    }

    public function testModifierActionWithValidData()
    {
        // Simuler une requête POST avec des données valides pour modifier un Tenrac
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['csrf_token'] = 'valid_token';
        $_POST['id'] = 1;
        $_POST['code_personnel'] = 'CP001';
        $_POST['nom'] = 'Tenrac Modifié';
        $_POST['email'] = 'modified@example.com';
        $_POST['numero'] = '0987654321';
        $_POST['adresse'] = '456 Rue Modifiée';
        $_POST['grade'] = 'Grand Chevalier';
        $_POST['rang'] = 'Compagnon';
        $_POST['titre'] = 'Protecteur';
        $_POST['dignite'] = 'Grand Maître';
        $_POST['structure_id'] = 1;

        // Mock des méthodes du modèle
        $tenracModelMock = $this->createMock(TenracModel::class);
        $tenracModelMock->method('obtenirTenrac')->willReturn(['id' => 1, 'nom' => 'Tenrac Test', 'email' => 'test@example.com']);
        $tenracModelMock->method('modifierTenrac')->willReturn(true);

        $controller = new TenracController();

        // Capture de l'affichage
        ob_start();
        $controller->modifierAction();
        $output = ob_get_clean();

        // Vérifier que la vue de modification est affichée
        $this->assertStringContainsString('gestion/modifier', $output, 'La vue de modification du Tenrac doit être affichée.');
    }

    public function testSupprimerAction()
    {
        // Simuler une requête GET pour supprimer un Tenrac
        $_GET['id'] = 1;

        // Mock de la méthode du modèle
        $tenracModelMock = $this->createMock(TenracModel::class);
        $tenracModelMock->method('supprimerTenrac')->willReturn(true);

        $controller = new TenracController();

        // Capture de la redirection après suppression
        ob_start();
        $controller->supprimerAction();
        $output = ob_get_clean();

        // Vérifier que l'utilisateur est redirigé après la suppression
        $this->assertStringContainsString('Location: index.php?ctrl=Login', $output, 'L\'utilisateur doit être redirigé après la suppression du Tenrac.');
    }

    public function testListerAction()
    {
        // Simuler une requête pour lister les Tenracs
        $controller = new TenracController();

        // Capture de l'affichage
        ob_start();
        $controller->listerAction();
        $output = ob_get_clean();

        // Vérifier que la vue de la liste des Tenracs est affichée
        $this->assertStringContainsString('gestion/lister', $output, 'La vue de la liste des Tenracs doit être affichée.');
    }
}
