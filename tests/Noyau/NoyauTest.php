<?php

use PHPUnit\Framework\TestCase;

class NoyauTest extends TestCase
{
    protected function setUp(): void
    {
        // Assurer que la connexion à la base de données est bien configurée
        require_once __DIR__ . '/../../modules/Noyau/Connexion.php';
    }

    public function testConnexionEstablishesConnection()
    {
        // Vérifie que la connexion PDO est établie correctement
        $this->assertNotNull(Connexion::execute('SELECT 1'), 'La connexion à la base de données doit être établie.');
    }

    public function testConnexionExecuteSelect()
    {
        // Tester l'exécution d'une requête SELECT sur une table existante
        $result = Connexion::execute('SELECT * FROM users WHERE id = ?', [1]);

        $this->assertIsArray($result, 'Le résultat de la requête devrait être un tableau.');
        $this->assertArrayHasKey('id', $result[0], 'La clé id devrait être présente dans les résultats.');
    }

    public function testConnexionInsertData()
    {
        // Tester l'insertion d'une ligne dans la base de données
        Connexion::execute('INSERT INTO users (username, password) VALUES (?, ?)', ['testuser', 'testpass']);
        $lastInsertId = Connexion::lastInsertId();

        $this->assertGreaterThan(0, $lastInsertId, 'L\'ID de la dernière insertion doit être supérieur à 0.');
    }
}
