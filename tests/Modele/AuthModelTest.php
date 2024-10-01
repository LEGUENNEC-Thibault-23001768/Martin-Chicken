<?php

use PHPUnit\Framework\TestCase;

class AuthModelTest extends TestCase
{
    protected $connexionMock;

    protected function setUp(): void
    {
        // Simuler une session PHP
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Mock de la classe Connexion pour éviter de faire de vraies requêtes à la base de données
        $this->connexionMock = $this->createMock(Connexion::class);
    }

    protected function tearDown(): void
    {
        // Nettoyage de la session après chaque test
        $_SESSION = [];
        parent::tearDown();
    }

    // Nous simulons la méthode statique getConnexion pour qu'elle retourne le mock
    public static function getConnexionMock()
    {
        return Connexion::class;
    }

    public function testLoginWithValidCredentials()
    {
        // Simuler le retour de la méthode Connexion::execute pour un utilisateur valide
        $this->connexionMock->method('execute')
            ->willReturn([
                [
                    'id' => 1,
                    'username' => 'validUser',
                    'password' => password_hash('validPassword', PASSWORD_DEFAULT)
                ]
            ]);

        // Injecter le mock de Connexion
        AuthModel::getConnexionMock();
        $result = AuthModel::login('validUser', 'validPassword');

        // Vérifier que l'utilisateur est bien connecté
        $this->assertTrue($result);
        $this->assertEquals(1, $_SESSION['user_id']);
        $this->assertEquals('validUser', $_SESSION['username']);
    }

    public function testLoginWithInvalidCredentials()
    {
        // Simuler le retour de la méthode Connexion::execute pour un utilisateur invalide
        $this->connexionMock->method('execute')
            ->willReturn([]);

        AuthModel::getConnexionMock();
        $result = AuthModel::login('invalidUser', 'invalidPassword');

        // Vérifier que la connexion échoue
        $this->assertFalse($result);
        $this->assertArrayNotHasKey('user_id', $_SESSION);
        $this->assertArrayNotHasKey('username', $_SESSION);
    }

    public function testLogout()
    {
        // Simuler un utilisateur connecté
        $_SESSION['user_id'] = 1;
        $_SESSION['username'] = 'testUser';

        // Appeler la méthode logout
        AuthModel::logout();

        // Vérifier que la session est détruite
        $this->assertEmpty($_SESSION);
    }

    public function testIsLoggedInWhenLoggedIn()
    {
        // Simuler un utilisateur connecté
        $_SESSION['user_id'] = 1;

        // Vérifier que isLoggedIn() retourne true
        $this->assertTrue(AuthModel::isLoggedIn());
    }

    public function testIsLoggedInWhenNotLoggedIn()
    {
        // Vérifier que isLoggedIn() retourne false quand l'utilisateur n'est pas connecté
        $this->assertFalse(AuthModel::isLoggedIn());
    }

    public function testCheckAuthWhenLoggedIn()
    {
        // Simuler un utilisateur connecté
        $_SESSION['user_id'] = 1;

        // Appeler checkAuth, vérifier que cela ne lève pas d'exception
        AuthModel::checkAuth();

        // Pas d'assertion ici, le but est de vérifier que l'appel ne déclenche pas d'erreur
        $this->assertTrue(true);
    }

    public function testCheckAuthWhenNotLoggedIn()
    {
        // Attendre une redirection si l'utilisateur n'est pas connecté
        $this->expectOutputRegex('/Location: \//');

        // Appeler checkAuth et vérifier qu'une redirection se produit
        AuthModel::checkAuth();
    }
}

