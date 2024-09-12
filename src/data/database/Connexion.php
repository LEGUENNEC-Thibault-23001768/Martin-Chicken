<?php

namespace data\database;

use data\superGlobal\Env;
use PDO;

class Connexion
{
    private static PDO $connexion;

    private static function connect(): void
    {
        if (isset(self::$connexion)) {
            return;
        }

        self::$connexion = new PDO(
            Env::$DSN,
            Env::$username,
            Env::$password,
            [
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
            ]
        );
        self::$connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    }

    public static function execute(string $query, ?array $args = null): ?array
    {
        self::connect();

        if(is_null($args)) {
            $statement = self::$connexion->query($query);
        } else {
            $statement = self::$connexion->prepare($query);
            $statement->execute($args);
        }

        return $statement->fetchAll(PDO::FETCH_ASSOC) ?? [];
    }
}