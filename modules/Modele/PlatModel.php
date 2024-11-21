<?php

final class PlatModel
{
    private static string $table = 'PLAT';

    public static function ajouterPlat(string $nom, bool $presence): int
    {
        $query = "INSERT INTO " . self::$table . " (Nom, Presence) VALUES (?, ?)";
        Connexion::execute($query, [$nom, $presence]);
        return Connexion::lastInsertId();
    }
    public static function modifierPlat(int $id, string $nom): array
    {
        $query = "UPDATE " . self::$table . " SET Nom = ? WHERE Id = ?";
        return Connexion::execute($query, [$nom, $id]);
    }

    public static function supprimerPlat(int $id): array
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
        $query = "SELECT Id,Nom,Presence FROM " . self::$table . " WHERE Id = ?";
        $result = Connexion::execute($query, [$id]);

        return !empty($result) ? $result[0] : null;
    }

    public static function associerIngredients(int $platId, array $ingredients): bool
    {
        $query = "INSERT INTO PLATS_INGREDIENTS (Plat_Id, Ingredient_Id) VALUES (?, ?)";
        $success = true;

        foreach ($ingredients as $ingredientId) {
            $result = Connexion::execute($query, [$platId, $ingredientId]);
            if (empty($result)) {
                $success = false;
            }
        }

        return $success;
    }

    public static function associerSauces(int $platId, array $sauces): bool
    {
        $query = "INSERT INTO PLATS_SAUCES (Plat_Id, Sauce_Id) VALUES (?, ?)";
        $success = true;

        foreach ($sauces as $sauceId) {
            $result = Connexion::execute($query, [$platId, $sauceId]);
            if (empty($result)) {
                $success = false;
            }
        }

        return $success;
    }

    public static function listerIngredients(): array
    {
        $query = "SELECT * FROM INGREDIENTS";
        return Connexion::execute($query);
    }

    public static function listerSauces(): array
    {
        $query = "SELECT * FROM SAUCES";
        return Connexion::execute($query);
    }

    public static function obtenirIngredientsPlat(int $platId): array
    {
        $query = "SELECT i.* FROM INGREDIENTS i 
                  JOIN PLATS_INGREDIENTS pi ON i.Id = pi.Ingredient_Id 
                  WHERE pi.Plat_Id = ?";
        return Connexion::execute($query, [$platId]);
    }

    public static function obtenirSaucesPlat(int $platId): array
    {
        $query = "SELECT s.* FROM SAUCES s 
                  JOIN PLATS_SAUCES ps ON s.Id = ps.Sauce_Id 
                  WHERE ps.Plat_Id = ?";
        return Connexion::execute($query, [$platId]);
    }

    //modifier

    public static function mettreAJourIngredients(int $platId, array $nouveauxIngredients): bool
    {
        // Supprimer tous les ingrédients actuels du plat
        $queryDelete = "DELETE FROM PLATS_INGREDIENTS WHERE Plat_Id = ?";
        Connexion::execute($queryDelete, [$platId]);

        // Ajouter les nouveaux ingrédients
        return self::associerIngredients($platId, $nouveauxIngredients);
    }

    public static function mettreAJourSauces(int $platId, array $nouvellesSauces): bool
    {
        // Supprimer toutes les sauces actuelles du plat
        $queryDelete = "DELETE FROM PLATS_SAUCES WHERE Plat_Id = ?";
        Connexion::execute($queryDelete, [$platId]);

        // Ajouter les nouvelles sauces
        return self::associerSauces($platId, $nouvellesSauces);
    }



}