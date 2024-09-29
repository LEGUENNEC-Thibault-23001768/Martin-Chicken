<?php

class OrdreModel
{
    public function findOrdre(): array
    {
        $query = "SELECT * FROM ordre WHERE type = 'principal'";
        return Connexion::execute($query);
    }

    public function findAllClubs(): array
    {
        $query = "SELECT * FROM ordre WHERE type = 'club'";
        return Connexion::execute($query);
    }
}
?>
