<?php

//namespace data\database;

use PDO;
use PDOException;

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

    public static function beginTransaction(): void
    {
        self::connect();
        self::$connexion->beginTransaction();
    }

    public static function commit(): void
    {
        self::connect();
        self::$connexion->commit();
    }

    public static function rollBack(): void
    {
        self::connect();
        self::$connexion->rollBack();
    }

    public static function lastInsertId(): string
    {
        self::connect();
        return self::$connexion->lastInsertId();
    }


    public static function execute(string $query, ?array $args = null): array
    {
        self::connect();

        try {
            if (is_null($args)) {
                $statement = self::$connexion->query($query);
            } else {
                $statement = self::$connexion->prepare($query);
                
                $statement->execute($args);
            }

            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Query execution failed: " . $e->getMessage());
        }
    }



}


interface Table
{
    public static function insert(array $data): int;
    public static function update(int $id, array $data): bool;
    public static function delete(int $id): bool;
    public static function findById(int $id): ?array;
    public static function findAll(): array;
}