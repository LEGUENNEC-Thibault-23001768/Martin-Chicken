<?php

final class OrdreController
{
    private $ordreModel;

    public function __construct()
    {
        $this->ordreModel = new OrdreModel();
    }

    public function defaultAction()
    {
        $ordre = $this->ordreModel->findOrdre();
        $clubs = $this->ordreModel->findAllClubs();

        Vue::montrer('ordre', ['ordre' => $ordre, 'clubs' => $clubs]);
    }
}
?>
