<?php

class PlatModel
{
    private $table = 'plats';

    public static function findAll(): array
    {
        $query = "SELECT * FROM plats ORDER BY nom ASC";
        return Connexion::execute($query);
    }

    public static function findById(int $id): ?array
    {
        $query = "SELECT * FROM plats WHERE id = :id";
        $result = Connexion::execute($query, ['id' => $id]);
        return $result[0] ?? null;
    }

    public static function insert(array $data): int
    {
        $query = "INSERT INTO plats (nom, ingredients, sauces, description) VALUES (:nom, :ingredients, :sauces, :description)";
        Connexion::execute($query, $data);
        return Connexion::lastInsertId();
    }

    public static function update(int $id, array $data): bool
    {
        $query = "UPDATE plats SET nom = :nom, ingredients = :ingredients, sauces = :sauces, description = :description WHERE id = :id";
        $data['id'] = $id;
        return Connexion::execute($query, $data) !== false;
    }

    public static function delete(int $id): bool
    {
        $query = "DELETE FROM plats WHERE id = :id";
        return Connexion::execute($query, ['id' => $id]) !== false;
    }
}
?>
