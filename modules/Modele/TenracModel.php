<?php

final class TenracModel
{
    private static string $table = 'TENRAC';

    public static function ajouterTenrac(array $data): int
    {
        $query = "INSERT INTO " . self::$table . " (Code_personnel, Nom, Email, Numero, Adresse, Grade, Rang, Titre, Dignite, Structure_Id) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        Connexion::execute($query, [
            $data['code_personnel'],
            $data['nom'],
            $data['email'],
            $data['numero'],
            $data['adresse'],
            $data['grade'],
            $data['rang'],
            $data['titre'],
            $data['dignite'],
            $data['structure_id']
        ]);
        return Connexion::lastInsertId();
    }

    public static function modifierTenrac(int $id, array $data): array
    {
        $query = "UPDATE " . self::$table . " SET 
                  Code_personnel = ?, Nom = ?, Email = ?, Numero = ?, Adresse = ?, 
                  Grade = ?, Rang = ?, Titre = ?, Dignite = ?, Structure_Id = ? 
                  WHERE Id = ?";
        return Connexion::execute($query, [
            $data['code_personnel'],
            $data['nom'],
            $data['email'],
            $data['numero'],
            $data['adresse'],
            $data['grade'],
            $data['rang'],
            $data['titre'],
            $data['dignite'],
            $data['structure_id'],
            $id
        ]);
    }

    public static function supprimerTenrac(int $id): bool
{
    $query = "DELETE FROM " . self::$table . " WHERE Id = ?";
    $result = Connexion::execute($query, [$id]);
    
        return true;
}


    public static function listerTenracs(): array
    {
        $query = "SELECT t.*, s.Nom as Structure_Nom 
                  FROM " . self::$table . " t
                  LEFT JOIN STRUCTURE s ON t.Structure_Id = s.Id";
        return Connexion::execute($query);
    }

    public static function obtenirTenrac(int $id): ?array
    {
        $query = "SELECT t.*, s.Nom as Structure_Nom 
                  FROM " . self::$table . " t
                  LEFT JOIN STRUCTURE s ON t.Structure_Id = s.Id
                  WHERE t.Id = ?";
        $result = Connexion::execute($query, [$id]);
        return !empty($result) ? $result[0] : null;
    }
}