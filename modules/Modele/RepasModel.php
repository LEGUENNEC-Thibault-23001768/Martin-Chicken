<?php

class RepasModel
{
    private $table = 'repas';

    public static function findAll(): array
    {
        $query = "SELECT * FROM repas ORDER BY date ASC";
        return Connexion::execute($query);
    }

    public static function findById(int $id): ?array
    {
        $query = "SELECT * FROM repas WHERE id = :id";
        $result = Connexion::execute($query, ['id' => $id]);
        return $result[0] ?? null;
    }

    public static function insert(array $data): int
    {
        $query = "INSERT INTO repas (titre, date, description) VALUES (:titre, :date, :description)";
        Connexion::execute($query, $data);
        return Connexion::lastInsertId();
    }

    public static function update(int $id, array $data): bool
    {
        $query = "UPDATE repas SET titre = :titre, date = :date, description = :description WHERE id = :id";
        $data['id'] = $id;
        return Connexion::execute($query, $data) !== false;
    }

    public static function delete(int $id): bool
    {
        $query = "DELETE FROM repas WHERE id = :id";
        return Connexion::execute($query, ['id' => $id]) !== false;
    }
}
?>
