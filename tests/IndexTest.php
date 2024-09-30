<?php

use PHPUnit\Framework\TestCase;

class IndexTest extends TestCase
{
    protected function setUp(): void
    {
        // Configuration de la session pour les tests
        session_save_path(__DIR__ . "/../sessions");
        session_start();
        
        // Charger l'autoloader
        require_once __DIR__ . '/../Noyau/autoloader.php';
    }

    public function testIndexPageLoadsCorrectly()
    {
        // Simuler les paramètres d'URL pour contrôler les actions
        $_GET['ctrl'] = 'accueil';
        $_GET['action'] = 'index';

        // Capturer la sortie
        ob_start();
        require __DIR__ . '/../index.php'; // Chemin vers ton fichier d'entrée
        $output = ob_get_clean();

        // Vérifier que le contrôleur et la vue sont correctement exécutés
        $this->assertStringContainsString('<body', $output); // Le corps HTML doit être rendu
        $this->assertStringContainsString('AccueilController', $output); // Vérifie que le contrôleur Accueil est bien utilisé
    }

    public function testPageWithoutControllerDefaultsToAccueil()
    {
        // Ne pas spécifier de contrôleur ni d'action
        $_GET = [];

        // Capturer la sortie
        ob_start();
        require __DIR__ . '/../index.php'; // Chemin vers ton fichier d'entrée
        $output = ob_get_clean();

        // Vérifier que l'action par défaut est exécutée
        $this->assertStringContainsString('AccueilController', $output); // Le contrôleur par défaut
        $this->assertStringContainsString('defautAction', $output); // L'action par défaut
    }
}
