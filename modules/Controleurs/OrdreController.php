<?php

final class OrdreController
{
    public $titre;

    public function __construct()
    {
        $this->titre = "l'Ordre";
    }

    public function defaultAction()
    {
        
        Vue::montrer('ordre');

    }

}
