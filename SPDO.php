<?php

define("DB_ADDR", "mysql-martin-chicken.alwaysdata.net");
define("DB_USER","374927");
define("DB_PASS","lechatrouge");
define("DB_NAME","martin-chicken_db");

// enlever les identifiant pour la secu 

namespace database;

use mysqli;
use Exception;

final class SPDO
{
    /**
     * @var SPDO|null Instance unique de SPDO pour le Singleton
     */
    private static ?SPDO $instance = null;

    /**
     * @var mysqli|null Instance MySQLi pour interagir avec la base de données
     */
    private ?mysqli $mysqliInstance = null;

    /**
     * @var string Nom du serveur utilisé pour la connexion
     */
    private string $serverName;

    /**
     * Constructeur privé pour initialiser la connexion MySQLi
     * 
     * @param string $serverName Nom du serveur (par exemple, ADMIN ou LECTOR)
     */
    private function __construct(string $serverName)
    {
        try {
            // Connexion à la base de données
            $this->mysqliInstance = new mysqli(
                DB_ADDR, 
                DB_USER, 
                DB_PASS, 
                DB_NAME  
            );

            // Vérifier la connexion
            if ($this->mysqliInstance->connect_error) {
                throw new Exception('Erreur de connexion : ' . $this->mysqliInstance->connect_error);
            }

            $this->serverName = $serverName;
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    /**
     * Méthode pour obtenir l'instance unique de SPDO
     * 
     * @param string $serverName Nom du serveur pour la connexion
     * @return SPDO Instance de SPDO
     */
    public static function getInstance(string $serverName): SPDO
    {
        // Créer une nouvelle instance si elle n'existe pas ou si le nom du serveur change
        if (is_null(self::$instance) || self::$instance->serverName !== $serverName) {
            self::$instance = new SPDO($serverName);
        }
        return self::$instance;
    }

    /**
     * Méthode pour préparer des requêtes SQL
     * 
     * @param string $query Requête SQL à préparer
     * @return mysqli_stmt|false
     */
    public function prepare(string $query)
    {
        return $this->mysqliInstance->prepare($query);
    }
}
