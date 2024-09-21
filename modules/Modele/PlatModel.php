<?php

class PlatModel
{
    private static string $table = 'PLAT';

    public static function ajouterPlat(string $nom, int $repas_id): bool
    {
        $query = "INSERT INTO " . self::$table . " (Nom, Repas_Id) VALUES (?, ?)";
        return Connexion::execute($query, [$nom, $repas_id]);
    }

    public static function modifierPlat(int $id, string $nom, int $repas_id): bool
    {
        $query = "UPDATE " . self::$table . " SET Nom = ?, Repas_Id = ? WHERE Id = ?";
        return Connexion::execute($query, [$nom, $repas_id, $id]);
    }

    public static function supprimerPlat(int $id): bool
    {
        $query = "DELETE FROM " . self::$table . " WHERE Id = ?";
        return Connexion::execute($query, [$id]);
    }

    public static function listerPlats(): array
    {
        $query = "SELECT * FROM " . self::$table;
        return Connexion::execute($query);
    }

    public static function obtenirPlat(int $id): ?array
    {
        $query = "SELECT * FROM " . self::$table . " WHERE Id = ?";
        $result = Connexion::execute($query, [$id]);

        return count($result) === 1 ? $result[0] : null;
    }
}
