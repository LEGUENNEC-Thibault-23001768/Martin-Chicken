<?php

namespace data\database;

interface AbstractTable
{
    public static function select($entity = null);
    public static function insert(&...$entities): array;
    public static function update($currentEntity, $newEntity): void;
    public static function delete($currentEntity): void;
    public static function exists($entity): bool;
}