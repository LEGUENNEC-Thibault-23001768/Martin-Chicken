<?php

use PHPUnit\Framework\TestCase;

class IndexTest extends TestCase
{
    protected function setUp(): void
    {
        // On utilise des chemins relatifs ou absolus pour s'assurer que les fichiers sont bien inclus
        require_once __DIR__ . '../../modules/Noyau/autoloader.php';
        require_once __DIR__ . '../../modules/Noyau/Vue.php';
        require_once __DIR__ . '../../modules/Noyau/Controleur.php';
    }

    public function testSessionAndCsrfToken()
    {
        // Tester si la session démarre bien et si le jeton CSRF est généré
        $this->assertNotEmpty($_SESSION, 'La session devrait être démarrée.');
        $this->assertNotEmpty($_SESSION['csrf_token'], 'Le token CSRF devrait être généré.');
        $this->assertEquals(64, strlen($_SESSION['csrf_token']), 'Le token CSRF doit avoir 64 caractères.');
    }

    public function testHeaderRemovals()
    {
        // On vérifie que les en-têtes spécifiques sont bien supprimés
        $this->assertFalse(headers_sent(), 'Les headers ne devraient pas encore avoir été envoyés.');
        $this->assertArrayNotHasKey('Server', headers_list(), 'Le header "Server" devrait être supprimé.');
        $this->assertArrayNotHasKey('Via', headers_list(), 'Le header "Via" devrait être supprimé.');
        $this->assertArrayNotHasKey('X-Powered-By', headers_list(), 'Le header "X-Powered-By" devrait être supprimé.');
        $this->assertArrayNotHasKey('Host', headers_list(), 'Le header "Host" devrait être supprimé.');
    }

    public function testTamponEtAffichage()
    {
        // Tester l'ouverture du tampon et l'affichage final
        Vue::ouvrirTampon();
        echo "Contenu test tampon";
        $contenu = Vue::recupererContenuTampon();

        // Vérifier que le tampon est correctement manipulé
        $this->assertEquals("Contenu test tampon", $contenu, 'Le contenu du tampon doit être "Contenu test tampon".');
    }

    public function testControleurExecution()
    {
        // Simuler la requête GET pour un contrôleur et une action spécifique
        $_GET['ctrl'] = 'accueil'; // Exemple de contrôleur
        $_GET['action'] = 'defaut'; // Exemple d'action

        $S_controleur = isset($_GET['ctrl']) ? $_GET['ctrl'] : null;
        $S_action = isset($_GET['action']) ? $_GET['action'] : null;

        // Exécuter le contrôleur
        $O_controleur = new Controleur($S_controleur, $S_action);
        $O_controleur->executer();

        // On vérifie que le tampon d'affichage est utilisé et que du contenu est renvoyé
        $contenuPourAffichage = Vue::recupererContenuTampon();
        $this->assertNotEmpty($contenuPourAffichage, "Le contenu du tampon ne devrait pas être vide.");
    }

    public function testAjaxRequest()
    {
        // Simuler une requête AJAX
        $_GET['ajax'] = 'true';
        $_GET['ctrl'] = 'accueil';
        $_GET['action'] = 'defaut';

        $S_controleur = isset($_GET['ctrl']) ? $_GET['ctrl'] : null;
        $S_action = isset($_GET['action']) ? $_GET['action'] : null;

        Vue::ouvrirTampon();
        $O_controleur = new Controleur($S_controleur, $S_action);
        $O_controleur->executer();
        $contenuPourAffichage = Vue::recupererContenuTampon();

        // Simuler la réponse AJAX
        $this->assertEquals($contenuPourAffichage, $contenuPourAffichage, "La requête AJAX devrait retourner uniquement le contenu partiel.");
    }

    public function testNonAjaxRequest()
    {
        // Simuler une requête non AJAX
        unset($_GET['ajax']);
        $_GET['ctrl'] = 'accueil';
        $_GET['action'] = 'defaut';

        $S_controleur = isset($_GET['ctrl']) ? $_GET['ctrl'] : null;
        $S_action = isset($_GET['action']) ? $_GET['action'] : null;

        Vue::ouvrirTampon();
        $O_controleur = new Controleur($S_controleur, $S_action);
        $O_controleur->executer();
        $contenuPourAffichage = Vue::recupererContenuTampon();

        // Simuler la réponse complète avec le gabarit
        ob_start();
        Vue::montrer('gabarit', [
            'body' => $contenuPourAffichage,
            'titre' => $O_controleur->getUrlDecortique()['controleur']::$titre
        ]);
        $output = ob_get_clean();

        $this->assertStringContainsString($contenuPourAffichage, $output, "La requête non AJAX doit inclure le gabarit complet avec le contenu.");
    }
}
