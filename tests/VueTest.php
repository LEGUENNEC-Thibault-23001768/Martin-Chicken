<?php

use PHPUnit\Framework\TestCase;

class VueTest extends TestCase
{
    public function testOuvrirEtRecupererTampon()
    {
        Vue::ouvrirTampon();
        echo "Test de tampon";
        $contenu = Vue::recupererContenuTampon();
        $this->assertEquals("Test de tampon", $contenu);
    }

    public function testMontrer()
    {
        // Simuler une vue
        $vuePath = __DIR__ . '/vues/test_view.php';
        file_put_contents($vuePath, '<h1><?= $A_vue["titre"] ?></h1>');

        // Modifier Constantes pour tester le répertoire des vues
        //Constantes::repertoireVues = __DIR__ . '/vues/';

        // Démarrer la capture de l'output
        ob_start();
        Vue::montrer('test_view', ['titre' => 'Titre de test']);
        $output = ob_get_clean();

        $this->assertStringContainsString('<h1>Titre de test</h1>', $output);

        unlink($vuePath); // Supprimer le fichier temporaire
    }
}
?>
