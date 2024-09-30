<?php

use PHPUnit\Framework\TestCase;

class AuthModelTest extends TestCase
{
    protected function setUp(): void
    {
        // Démarrer une session pour les tests
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Simuler l'autoloader si nécessaire
        require_once __DIR__ . '/../Noyau/autoloader.php';
    }

    public function testLoginWithValidCredentials()
    {
        // Simuler un utilisateur valide en base de données
        $mockedResult = [
            [
                'id' => 1,
                'username' => 'validuser',
                'password' => password_hash('validpass', PASSWORD_DEFAULT)
            ]
        ];

        // Simuler la méthode execute de Connexion pour retourner un utilisateur valide
        $connexionMock = $this->createMock(Connexion::class);
        $connexionMock->method('execute')
                      ->willReturn($mockedResult);

        // Simuler un login réussi
        $result = AuthModel::login('validuser', 'validpass');
        $this->assertTrue($result);

        // Vérifier les valeurs de session
        $this->assertEquals(1, $_SESSION['user_id']);
        $this->assertEquals('validuser', $_SESSION['username']);
    }

    public function testLoginWithInvalidCredentials()
    {
        // Simuler une requête où l'utilisateur n'existe pas
        $connexionMock = $this->createMock(Connexion::class);
        $connexionMock->method('execute')
                      ->willReturn([]);

        // Simuler un login échoué
        $result = AuthModel::login('invaliduser', 'invalidpass');
        $this->assertFalse($result);

        // Vérifier qu'aucune session n'est définie
        $this->assertArrayNotHasKey('user_id', $_SESSION);
        $this->assertArrayNotHasKey('username', $_SESSION);
    }

    public function testLogout()
    {
        // Simuler un utilisateur connecté
        $_SESSION['user_id'] = 1;
        $_SESSION['username'] = 'validuser';

        // Appeler la méthode logout
        AuthModel::logout();

        // Vérifier que la session est bien vide après la déconnexion
        $this->assertEmpty($_SESSION);
    }

    public function testIsLoggedIn()
    {
        // Simuler un utilisateur connecté
        $_SESSION['user_id'] = 1;

        $this->assertTrue(AuthModel::isLoggedIn());

        // Simuler un utilisateur non connecté
        unset($_SESSION['user_id']);

        $this->assertFalse(AuthModel::isLoggedIn());
    }

    public function testGetCurrentUser()
    {
        // Simuler un utilisateur connecté
        $_SESSION['user_id'] = 1;

        // Simuler la méthode findById pour retourner un utilisateur
        $mockedUser = [
            'id' => 1,
            'username' => 'validuser'
        ];

        // Mock de la méthode findById pour retourner l'utilisateur actuel
        $connexionMock = $this->createMock(Connexion::class);
        $connexionMock->method('execute')
                      ->willReturn([$mockedUser]);

        // Appeler getCurrentUser
        $user = AuthModel::getCurrentUser();

        // Vérifier que les informations de l'utilisateur sont correctes
        $this->assertEquals($mockedUser, $user);
    }

}
?>
