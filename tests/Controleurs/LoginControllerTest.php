<?php

use PHPUnit\Framework\TestCase;

class LoginControllerTest extends TestCase
{
    protected function setUp(): void
    {
        // Inclure les dépendances nécessaires
        require_once __DIR__ . '/../../modules/Noyau/Connexion.php';
        require_once __DIR__ . '/../../modules/Noyau/Vue.php';
        require_once __DIR__ . '/../../modules/Modele/AuthModel.php';
        require_once __DIR__ . '/../../modules/Controleurs/LoginController.php';

        // Simuler une session PHP
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function testDefautActionWhenLoggedIn()
    {
        // Simuler un utilisateur connecté
        $_SESSION['user_id'] = 1; // Simuler que l'utilisateur est connecté

        $controller = new LoginController();

        // Capture de l'affichage
        ob_start();
        $controller->defautAction();
        $output = ob_get_clean();

        // Vérifier que la vue "compte" est montrée quand l'utilisateur est connecté
        $this->assertStringContainsString('compte', $output, 'La vue "compte" doit être affichée si l\'utilisateur est connecté.');
    }

    public function testDefautActionWhenNotLoggedIn()
    {
        // Simuler un utilisateur non connecté
        unset($_SESSION['user_id']);

        // Simuler une erreur de connexion
        $_SESSION['login_error'] = 'Erreur de connexion';

        $controller = new LoginController();

        // Capture de l'affichage
        ob_start();
        $controller->defautAction();
        $output = ob_get_clean();

        // Vérifier que la vue "compte" est affichée avec un message d'erreur
        $this->assertStringContainsString('Erreur de connexion', $output, 'Le message d\'erreur doit être affiché pour l\'utilisateur non connecté.');
    }

    public function testLoginActionWithInvalidCsrfToken()
    {
        // Simuler une requête POST avec un token CSRF invalide
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['csrf_token'] = 'invalid_token';
        $_SESSION['csrf_token'] = 'valid_token'; // CSRF réel

        $controller = new LoginController();

        // Capture de l'erreur fatale CSRF
        $this->expectOutputString('CSRF token validation failed');
        $controller->loginAction();
    }

    public function testLoginActionWithInvalidCredentials()
    {
        // Simuler une requête POST avec des identifiants invalides
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['csrf_token'] = 'valid_token';
        $_SESSION['csrf_token'] = 'valid_token';
        $_POST['username'] = 'fakeuser';
        $_POST['password'] = 'fakepassword';

        // Simuler la connexion avec des identifiants invalides
        $auth_model_mock = $this->createMock(AuthModel::class);
        $auth_model_mock->method('login')->willReturn(false);

        // S'assurer qu'une erreur de connexion est bien stockée
        $controller = new LoginController();
        $controller->loginAction();

        $this->assertEquals("Mauvais nom d'utilisateur ou mot de passe", $_SESSION['login_error'], "L'erreur de connexion doit être enregistrée.");
    }

    public function testLoginActionWithValidCredentials()
    {
        // Simuler une requête POST avec des identifiants valides
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['csrf_token'] = 'valid_token';
        $_SESSION['csrf_token'] = 'valid_token';
        $_POST['username'] = 'validuser';
        $_POST['password'] = 'validpassword';

        // Simuler la connexion avec des identifiants valides
        $auth_model_mock = $this->createMock(AuthModel::class);
        $auth_model_mock->method('login')->willReturn(true);

        $controller = new LoginController();

        // Capture de la redirection
        ob_start();
        $controller->loginAction();
        $output = ob_get_clean();

        // Vérifier que l'utilisateur est redirigé vers la page des repas
        $this->assertStringContainsString('Location: index.php?ctrl=Repas', $output, "L'utilisateur doit être redirigé vers la page des repas après une connexion réussie.");
    }
}
