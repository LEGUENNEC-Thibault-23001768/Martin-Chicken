<?php

namespace data\database;

use domain\User;

class UserTable implements AbstractTable
{
    public static function select(null|int|User|string $user = null): User|array
    {
        $query = "SELECT * FROM USER";

        if(is_int($user)) {
            $query .= " WHERE Id = :id";
            $results = Connexion::execute($query, [':id' => $user]);
        } else if (!is_null($user)) {
            $query .= " WHERE Name = :name";
            $name = $user instanceof User ? $user->getName() : $user;
            $results = Connexion::execute($query, [':name' => $name]);
        } else {
            $results = Connexion::execute($query);
        }

        $users = [];
        foreach ($results as $result) {
            $user = new User($result['name'], $result['password']);
            $user->setId($result['id']);
            $users[] = $user;
        }

        if(count($users) === 1) {
            return $users[0];
        }

        return $users;
    }

    /**
     * @param User ...$entities
     * @return User[]
     */

    public static function insert(&...$entities): array
    {
        $insertedEntities = [];
        foreach ($entities as &$entity) {
            $query = "INSERT INTO USER (Name, Password) VALUES (:name, :password)";

            Connexion::execute($query, [
                ':name' => $entities[0]->getCredentials()->getName(),
                ':password' => $entities[0]->getCredentials()->getPassword()
            ]);

            $id = self::select($entity->getCredentials()->getName())['id'];
            $entity->setId($id);
        }
        return $insertedEntities;

    }

    /**
     * @param User $currentEntity
     * @param User $newEntity
     * @return void
     */

    public static function update($currentEntity, $newEntity): void
    {
        $query = "UPDATE USER SET Name = :name, Password = :password WHERE id = :id";

        Connexion::execute($query, [
            ':name' => $newEntity->getCredentials()->getName(),
            ':password' => $newEntity->getCredentials()->getPassword(),
            ':id' => $currentEntity->getId()
        ]);
    }

    public static function delete($currentEntity): void
    {
        $query = "DELETE FROM USER WHERE Id = :id";

        $id = $currentEntity instanceof User ? $currentEntity->getId() : $currentEntity;

        Connexion::execute($query, [':id' => $id]);
    }

    public static function exists($entity): bool
    {
        return count(self::select($entity)) === 1;
    }
}