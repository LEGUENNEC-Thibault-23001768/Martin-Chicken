<?php

use PHPUnit\Framework\TestCase;

class PlatControllerTest extends TestCase
{
    protected function setUp(): void
    {
        // Inclure les dépendances nécessaires
        require_once __DIR__ . '/../modules/Noyau/Vue.php';
        require_once __DIR__ . '/../modules/Modele/AuthModel.php';
        require_once __DIR__ . '/../modules/Modele/PlatModel.php';
        require_once __DIR__ . '/../modules/Controleurs/PlatController.php';

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
        $controller = new PlatController();

        // Capture de l'affichage
        ob_start();
        $controller->defautAction();
        $output = ob_get_clean();

        // Vérifier que la vue de la liste des plats est affichée
        $this->assertStringContainsString('gestion/lister', $output, 'La vue de gestion des plats doit être affichée.');
    }

    public function testAjouterActionWithValidData()
    {
        // Simuler une requête POST avec des données valides
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['csrf_token'] = 'valid_token';
        $_POST['nom'] = 'Plat Test';
        $_POST['ingredients'] = [1, 2];
        $_POST['sauces'] = [1];

        // Mock des méthodes du modèle
        $platModelMock = $this->createMock(PlatModel::class);
        $platModelMock->method('ajouterPlat')->willReturn(1);
        $platModelMock->method('associerIngredients')->willReturn(true);
        $platModelMock->method('associerSauces')->willReturn(true);

        $controller = new PlatController();

        // Capture de la redirection
        ob_start();
        $controller->ajouterAction();
        $output = ob_get_clean();

        // Vérifier que l'utilisateur est redirigé après l'ajout du plat
        $this->assertStringContainsString('Location: index.php?ctrl=Login', $output, 'L\'utilisateur doit être redirigé après l\'ajout du plat.');
    }

    public function testAjouterActionWithMissingData()
    {
        // Simuler une requête POST avec des données manquantes
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['csrf_token'] = 'valid_token';
        $_POST['nom'] = '';  // Nom vide

        $controller = new PlatController();

        // Capture de l'affichage avec erreur
        ob_start();
        $controller->ajouterAction();
        $output = ob_get_clean();

        // Vérifier que l'erreur est bien affichée
        $this->assertStringContainsString('Veuillez remplir tous les champs obligatoires', $output, 'Un message d\'erreur doit être affiché lorsque des champs sont manquants.');
    }

    public function testModifierActionWithValidData()
    {
        // Simuler une requête POST avec des données valides pour modifier un plat
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['csrf_token'] = 'valid_token';
        $_POST['id'] = 1;
        $_POST['nom'] = 'Plat Modifié';
        $_POST['ingredients'] = [1, 2];
        $_POST['sauces'] = [1];

        // Mock des méthodes du modèle
        $platModelMock = $this->createMock(PlatModel::class);
        $platModelMock->method('obtenirPlat')->willReturn(['id' => 1, 'nom' => 'Plat Test']);
        $platModelMock->method('modifierPlat')->willReturn(true);
        $platModelMock->method('mettreAJourIngredients')->willReturn(true);
        $platModelMock->method('mettreAJourSauces')->willReturn(true);

        $controller = new PlatController();

        // Capture de l'affichage
        ob_start();
        $controller->modifierAction();
        $output = ob_get_clean();

        // Vérifier que la vue de modification est affichée
        $this->assertStringContainsString('gestion/modifier', $output, 'La vue de modification du plat doit être affichée.');
    }

    public function testSupprimerAction()
    {
        // Simuler une requête GET pour supprimer un plat
        $_GET['id'] = 1;

        // Mock de la méthode du modèle
        $platModelMock = $this->createMock(PlatModel::class);
        $platModelMock->method('supprimerPlat')->willReturn(true);

        $controller = new PlatController();

        // Capture de la redirection après suppression
        ob_start();
        $controller->supprimerAction();
        $output = ob_get_clean();

        // Vérifier que l'utilisateur est redirigé après la suppression
        $this->assertStringContainsString('Location: index.php?ctrl=Login', $output, 'L\'utilisateur doit être redirigé après la suppression du plat.');
    }

    public function testListerAction()
    {
        // Simuler une requête pour lister les plats
        $controller = new PlatController();

        // Capture de l'affichage
        ob_start();
        $controller->listerAction();
        $output = ob_get_clean();

        // Vérifier que la vue de la liste des plats est affichée
        $this->assertStringContainsString('gestion/lister', $output, 'La vue de la liste des plats doit être affichée.');
    }
}
