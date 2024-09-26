<?php

class StructureModel
{
    private static string $table = 'STRUCTURE';

    public static function ajouterStructure(string $type, string $nom, string $adresse): int
    {
        $query = "INSERT INTO " . self::$table . " (Type, Nom, Adresse) VALUES (?, ?, ?)";
        Connexion::execute($query, [$type, $nom, $adresse]);
        return Connexion::lastInsertId();
    }

    public static function modifierStructure(int $id, string $nom, string $adresse): bool
    {
        $query = "UPDATE " . self::$table . " SET Nom = ?, Adresse = ? WHERE Id = ?";
        return Connexion::execute($query, [$nom, $adresse, $id]);
    }

    public static function supprimerStructure(int $id): bool
    {
        $query = "DELETE FROM " . self::$table . " WHERE Id = ?";
        return Connexion::execute($query, [$id]);
    }

    public static function listerStructures(): array
    {
        $query = "SELECT * FROM " . self::$table;
        return Connexion::execute($query);
    }

    public static function obtenirStructure(int $id): ?array
    {
        $query = "SELECT * FROM " . self::$table . " WHERE Id = ?";
        $result = Connexion::execute($query, [$id]);
        return !empty($result) ? $result[0] : null;
    }

    public static function listerClubs(): array
    {
        $query = "SELECT * FROM " . self::$table . " WHERE Type = 'Club'";
        return Connexion::execute($query);
    }

    public static function obtenirOrdre(): ?array
    {
        $query = "SELECT * FROM " . self::$table . " WHERE Type = 'Ordre' LIMIT 1";
        $result = Connexion::execute($query);
        return !empty($result) ? $result[0] : null;
    }
}
