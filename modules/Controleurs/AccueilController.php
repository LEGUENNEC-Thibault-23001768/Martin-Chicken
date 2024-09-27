 <?php

final class AccueilController
{
    public $titre;

    public function __construct()
    {
        $this->titre = "Accueil";
    }

    public function defaultAction()
    {
        
        Vue::montrer('accueil');

    }

}
