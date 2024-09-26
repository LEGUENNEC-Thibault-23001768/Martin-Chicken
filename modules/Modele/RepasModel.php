<?php

final class RepasModel
{
    private static string $table = 'REPAS';

    public static function ajouterRepas(string $nom, string $date, string $adresse, bool $presence = false): array
    {
        $query = "INSERT INTO " . self::$table . " (Nom, Datee, Adresse, Presence) VALUES (?, ?, ?, ?)";
        $aa   = Connexion::execute($query, [$nom, $date, $adresse, $presence]);
        error_log(print_r($aa,true));
    }

    public static function modifierRepas(int $id, string $nom, string $date, string $adresse, bool $presence = false): array
    {
        $query = "UPDATE " . self::$table . " SET Nom = ?, Datee = ?,  Adresse = ?, Presence = ? WHERE Id = ?";
        return Connexion::execute($query, [$nom, $date, $adresse, $presence, $id]);
    }

    public static function supprimerRepas(int $id): bool
    {
        $query = "DELETE FROM " . self::$table . " WHERE Id = ?";
        return Connexion::execute($query, [$id]);
    }

    public static function listerRepas(): array
    {
        $query = "SELECT * FROM " . self::$table . " ORDER BY Datee DESC";
        return Connexion::execute($query);
    }

    public static function obtenirRepas(int $id): ?array
    {
        $query = "SELECT * FROM " . self::$table . " WHERE Id = ?";
        $result = Connexion::execute($query, [$id]);
        return $result ? $result[0] : null;
    }

    public static function listerPlatsRepas(int $repas_id): array
    {
        $query = "SELECT * FROM PLAT WHERE Repas_Id = ?";
        return Connexion::execute($query, [$repas_id]);
    }

    public static function ajouterParticipant(int $repas_id, int $tenrac_id): bool
    {
        $query = "INSERT INTO REPAS_PARTICIPANT (Repas_Id, Tenrac_Id) VALUES (?, ?)";
        return Connexion::execute($query, [$repas_id, $tenrac_id]);
    }

    public static function retirerParticipant(int $repas_id, int $tenrac_id): bool
    {
        $query = "DELETE FROM REPAS_PARTICIPANT WHERE Repas_Id = ? AND Tenrac_Id = ?";
        return Connexion::execute($query, [$repas_id, $tenrac_id]);
    }

    public static function listerParticipants(int $repas_id): array
    {
        $query = "SELECT t.* FROM TENRAC t
                  JOIN REPAS_PARTICIPANT rp ON t.Id = rp.Tenrac_Id
                  WHERE rp.Repas_Id = ?";
        return Connexion::execute($query, [$repas_id]);
    }

    public static function verifierParticipation(int $repas_id, int $tenrac_id): bool
    {
        $query = "SELECT COUNT(*) as count FROM REPAS_PARTICIPANT 
                  WHERE Repas_Id = ? AND Tenrac_Id = ?";
        $result = Connexion::execute($query, [$repas_id, $tenrac_id]);
        return $result[0]['count'] > 0;
    }

    public static function listerRepasParticipant(int $tenrac_id): array
    {
        $query = "SELECT r.* FROM " . self::$table . " r
                  JOIN REPAS_PARTICIPANT rp ON r.Id = rp.Repas_Id
                  WHERE rp.Tenrac_Id = ?
                  ORDER BY r.Datee DESC";
        return Connexion::execute($query, [$tenrac_id]);
    }
}