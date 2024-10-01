<?php
final class AccueilController
{
    public static string $titre  = "gros zizi";
    
    public function defaultAction()
    {
        Vue::montrer("accueil", "");
    }
}