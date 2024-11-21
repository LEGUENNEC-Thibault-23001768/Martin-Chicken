<?php

use PHPUnit\Framework\TestCase;

class RepasControllerTest extends TestCase
{
    protected function setUp(): void
    {
        // Inclure les dépendances nécessaires
        require_once __DIR__ . '/../modules/Noyau/Vue.php';
        require_once __DIR__ . '/../modules/Modele/AuthModel.php';
        require_once __DIR__ . '/../modules/Modele/RepasModel.php';
        require_once __DIR__ . '/../modules/Modele/PlatModel.php';
        require_once __DIR__ . '/../modules/Controleurs/RepasController.php';

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
        $controller = new RepasController();

        // Capture de l'affichage
        ob_start();
        $controller->defautAction();
        $output = ob_get_clean();

        // Vérifier que la vue de la liste des repas est affichée
        $this->assertStringContainsString('gestion/lister', $output, 'La vue de gestion des repas doit être affichée.');
    }

    public function testAjouterActionWithValidData()
    {
        // Simuler une requête POST avec des données valides
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['csrf_token'] = 'valid_token';
        $_POST['nom'] = 'Repas Test';
        $_POST['date'] = '2024-01-01';
        $_POST['adresse'] = 'Adresse Test';
        $_POST['plats'] = [1, 2];

        // Mock des méthodes du modèle
        $repasModelMock = $this->createMock(RepasModel::class);
        $repasModelMock->method('ajouterRepas')->willReturn(1);
        $repasModelMock->method('associerPlats')->willReturn(true);

        $controller = new RepasController();

        // Capture de la redirection
        ob_start();
        $controller->ajouterAction();
        $output = ob_get_clean();

        // Vérifier que l'utilisateur est redirigé après l'ajout du repas
        $this->assertStringContainsString('Location: index.php?ctrl=Login', $output, 'L\'utilisateur doit être redirigé après l\'ajout du repas.');
    }

    public function testAjouterActionWithMissingData()
    {
        // Simuler une requête POST avec des données manquantes
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['csrf_token'] = 'valid_token';
        $_POST['nom'] = '';  // Nom manquant

        $controller = new RepasController();

        // Capture de l'affichage avec erreur
        ob_start();
        $controller->ajouterAction();
        $output = ob_get_clean();

        // Vérifier que l'erreur est bien affichée
        $this->assertStringContainsString('Veuillez remplir tous les champs obligatoires', $output, 'Un message d\'erreur doit être affiché lorsque des champs sont manquants.');
    }

    public function testModifierActionWithValidData()
    {
        // Simuler une requête POST avec des données valides pour modifier un repas
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['csrf_token'] = 'valid_token';
        $_POST['id'] = 1;
        $_POST['nom'] = 'Repas Modifié';
        $_POST['date'] = '2024-01-01';
        $_POST['adresse'] = 'Adresse Modifiée';
        $_POST['plats'] = [1, 2];

        // Mock des méthodes du modèle
        $repasModelMock = $this->createMock(RepasModel::class);
        $repasModelMock->method('obtenirRepas')->willReturn(['id' => 1, 'nom' => 'Repas Test', 'date' => '2024-01-01', 'adresse' => 'Adresse Test']);
        $repasModelMock->method('modifierRepas')->willReturn(true);
        $repasModelMock->method('mettreAJourPlats')->willReturn(true);

        $controller = new RepasController();

        // Capture de l'affichage
        ob_start();
        $controller->modifierAction();
        $output = ob_get_clean();

        // Vérifier que la vue de modification est affichée
        $this->assertStringContainsString('gestion/modifier', $output, 'La vue de modification du repas doit être affichée.');
    }

    public function testSupprimerAction()
    {
        // Simuler une requête GET pour supprimer un repas
        $_GET['id'] = 1;

        // Mock de la méthode du modèle
        $repasModelMock = $this->createMock(RepasModel::class);
        $repasModelMock->method('supprimerRepas')->willReturn(true);

        $controller = new RepasController();

        // Capture de la redirection après suppression
        ob_start();
        $controller->supprimerAction();
        $output = ob_get_clean();

        // Vérifier que l'utilisateur est redirigé après la suppression
        $this->assertStringContainsString('Location: index.php?ctrl=Login', $output, 'L\'utilisateur doit être redirigé après la suppression du repas.');
    }

    public function testListerAction()
    {
        // Simuler une requête pour lister les repas
        $controller = new RepasController();

        // Capture de l'affichage
        ob_start();
        $controller->listerAction();
        $output = ob_get_clean();

        // Vérifier que la vue de la liste des repas est affichée
        $this->assertStringContainsString('gestion/lister', $output, 'La vue de la liste des repas doit être affichée.');
    }

    public function testRechercherActionWithResults()
    {
        // Simuler une requête GET avec un terme de recherche valide
        $_GET['terme'] = 'Repas';

        // Mock de la méthode de recherche dans le modèle
        $repasModelMock = $this->createMock(RepasModel::class);
        $repasModelMock->method('rechercherRepas')->willReturn([['id' => 1, 'nom' => 'Repas Test']]);

        $controller = new RepasController();

        // Capture de l'affichage de la recherche
        ob_start();
        $controller->rechercherAction();
        $output = ob_get_clean();

        // Vérifier que les résultats de recherche sont affichés
        $this->assertStringContainsString('Repas Test', $output, 'Les résultats de recherche doivent être affichés.');
    }

    public function testRechercherActionWithoutTerm()
    {
        // Simuler une requête GET sans terme de recherche
        $_GET['terme'] = '';

        $controller = new RepasController();

        // Capture de la redirection
        ob_start();
        $controller->rechercherAction();
        $output = ob_get_clean();

        // Vérifier que l'utilisateur est redirigé vers la page de login en l'absence de terme de recherche
        $this->assertStringContainsString('Location: index.php?ctrl=Login', $output, 'L\'utilisateur doit être redirigé en l\'absence de terme de recherche.');
    }
}
