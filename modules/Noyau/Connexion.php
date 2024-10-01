<?php

//namespace data\database;


define("DB_HOST", "mysql-martin-chicken.alwaysdata.net");
define("DB_NAME", "martin-chicken_db");
define("DB_USER", getenv('DB_USER') ?: "374927");
define("DB_PASS", getenv('DB_PASS') ?: "lechatrouge");

class Connexion
{
    private static ?PDO $connexion = null;

    private static function connect(): void
    {
        if (self::$connexion !== null) {
            return;
        }

        try {
            self::$connexion = new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME,
                DB_USER,
                DB_PASS,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
                ]
            );
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }
    public static function lastInsertId(): int
    {
        return self::$connexion->lastInsertId();
    }

    public static function execute(string $query, ?array $args = null): array
    {
        self::connect();
        try {
            self::$connexion->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
            
            if (is_null($args)) {
                $statement = self::$connexion->query($query);
            } else {
                $statement = self::$connexion->prepare($query);
                
                $statement->execute($args);
            }

            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {

            // log and rethrow error
            
            die("Query execution failed: " . $e->getMessage());
        }
    }

    
}