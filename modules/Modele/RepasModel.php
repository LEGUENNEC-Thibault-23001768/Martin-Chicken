<?php

final class RepasModel
{
    private static string $table = 'REPAS';

    public static function ajouterRepas(string $nom, string $date, string $adresse): int
    {
        $query = "INSERT INTO " . self::$table . " (Nom, Date, Adresse) VALUES (?, ?, ?)";
        Connexion::execute($query, [$nom, $date, $adresse]);
        return Connexion::lastInsertId();
    }

    public static function modifierRepas(int $id, string $nom, string $date, string $adresse): array
    {
        $query = "UPDATE " . self::$table . " SET Nom = ?, Date = ?, Adresse = ? WHERE Id = ?";
        return Connexion::execute($query, [$nom, $date, $adresse, $id]);
    }

    public static function supprimerRepas(int $id): array
    {
        $query = "DELETE FROM " . self::$table . " WHERE Id = ?";
        return Connexion::execute($query, [$id]);
    }

    public static function listerRepas(): array
    {
        $query = "SELECT * FROM " . self::$table;
        return Connexion::execute($query);
    }

    public static function obtenirRepas(int $id): ?array
    {
        $query = "SELECT Id, Nom, Date, Adresse FROM " . self::$table . " WHERE Id = ?";
        $result = Connexion::execute($query, [$id]);
        return !empty($result) ? $result[0] : null;
    }

    public static function associerPlats(int $repasId, array $plats): bool
    {
        $query = "INSERT INTO REPAS_PLATS (Repas_Id, Plat_Id) VALUES (?, ?)";
        $success = true;

        foreach ($plats as $platId) {
            $result = Connexion::execute($query, [$repasId, $platId]);
            if (empty($result)) {
                $success = false;
            }
        }

        return $success;
    }

    public static function obtenirPlatsRepas(int $repasId): array
    {
        $query = "SELECT p.Id, p.Nom, p.Presence 
                FROM PLAT p 
                JOIN REPAS_PLATS rp ON p.Id = rp.Plat_Id 
                WHERE rp.Repas_Id = ?";
        $plats = Connexion::execute($query, [$repasId]);

        // Ajouter les ingrédients pour chaque plat
        foreach ($plats as &$plat) {
            $plat['ingredients'] = self::obtenirIngredientsPourPlat($plat['id']);
        }

        return $plats;
    }

    private static function obtenirIngredientsPourPlat(int $platId): array
    {
        $query = "SELECT i.Nom 
                FROM INGREDIENTS i
                JOIN PLATS_INGREDIENTS pi ON i.Id = pi.Ingredient_Id
                WHERE pi.Plat_Id = ?";
        $ingredients = Connexion::execute($query, [$platId]);
        return array_column($ingredients, 'nom');
    }

    public static function mettreAJourPlats(int $repasId, array $nouveauxPlats): bool
    {
        // Supprimer tous les plats actuels du repas
        $queryDelete = "DELETE FROM REPAS_PLATS WHERE Repas_Id = ?";
        Connexion::execute($queryDelete, [$repasId]);

        // Ajouter les nouveaux plats
        return self::associerPlats($repasId, $nouveauxPlats);
    }

    // Méthodes supplémentaires si nécessaire

    public static function listerRepasAvecPlats(): array
    {
        $query = "SELECT r.*, GROUP_CONCAT(DISTINCT p.Nom SEPARATOR ', ') as Plats,
            GROUP_CONCAT(DISTINCT i.Nom SEPARATOR ', ') as Ingredients
            FROM " . self::$table . " r
            LEFT JOIN REPAS_PLATS rp ON r.Id = rp.Repas_Id
            LEFT JOIN PLAT p ON rp.Plat_Id = p.Id
            LEFT JOIN PLATS_INGREDIENTS pi ON p.Id = pi.Plat_Id
            LEFT JOIN INGREDIENTS i ON pi.Ingredient_Id = i.Id
            GROUP BY r.Id";
        return Connexion::execute($query);
    }

    public static function rechercherRepas(string $terme): array
    {
        $query = "SELECT * FROM " . self::$table . " 
                  WHERE Nom LIKE ? OR Adresse LIKE ?";
        $termeLike = "%$terme%";
        return Connexion::execute($query, [$termeLike, $termeLike]);
    }
}