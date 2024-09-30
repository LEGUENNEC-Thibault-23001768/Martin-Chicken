<?php

use PHPUnit\Framework\TestCase;

class LoginControllerTest extends TestCase
{
    protected function setUp(): void
    {
        // Démarrer la session pour les tests
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Simuler l'autoloader si nécessaire
        require_once __DIR__ . '/../Noyau/autoloader.php';
    }

    public function testDefautActionWhenLoggedIn()
    {
        // Simuler un utilisateur connecté
        $authMock = $this->createMock(AuthModel::class);
        $authMock->method('isLoggedIn')->willReturn(true);

        // Capturer la sortie du header pour vérifier la redirection
        $this->expectOutputRegex('/Location: \/\?ctrl=Plat/');

        $controller = new LoginController();
        $controller->defautAction();
    }

    public function testDefautActionWhenNotLoggedIn()
    {
        // Simuler un utilisateur non connecté
        $authMock = $this->createMock(AuthModel::class);
        $authMock->method('isLoggedIn')->willReturn(false);

        // Simuler une erreur de connexion dans la session
        $_SESSION['login_error'] = "Erreur simulée";

        // Capturer l'affichage de la vue
        ob_start();
        $controller = new LoginController();
        $controller->defautAction();
        $output = ob_get_clean();

        // Vérifier que l'erreur est affichée dans la vue
        $this->assertStringContainsString('Erreur simulée', $output);
    }

    public function testLoginActionWithInvalidCredentials()
    {
        // Simuler la méthode login renvoyant faux (échec)
        $authMock = $this->createMock(AuthModel::class);
        $authMock->method('login')->willReturn(false);

        // Simuler les données de POST
        $_POST['username'] = 'wronguser';
        $_POST['password'] = 'wrongpass';

        // Capturer la sortie du header pour vérifier la redirection
        $this->expectOutputRegex('/Location: index\.php\?ctrl=Login/');

        // Exécuter l'action
        $controller = new LoginController();
        $controller->loginAction();

        // Vérifier que l'erreur est enregistrée dans la session
        $this->assertEquals('Mauvais nom d\'utilisateur ou mot de passe', $_SESSION['login_error']);
    }

    public function testLoginActionWithValidCredentials()
    {
        // Simuler la méthode login renvoyant vrai (succès)
        $authMock = $this->createMock(AuthModel::class);
        $authMock->method('login')->willReturn(true);

        // Simuler les données de POST
        $_POST['username'] = 'validuser';
        $_POST['password'] = 'validpass';

        // Capturer la sortie du header pour vérifier la redirection
        $this->expectOutputRegex('/Location: index\.php\?ctrl=Repas/');

        // Exécuter l'action
        $controller = new LoginController();
        $controller->loginAction();

        // Vérifier qu'aucune erreur de session n'est définie
        $this->assertArrayNotHasKey('login_error', $_SESSION);
    }
}
?>
