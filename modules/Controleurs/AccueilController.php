<?php
final class AccueilController
{
    public static string $titre  = "Accueil";
    
    public function defaultAction()
    {
        Vue::montrer("accueil", "");
    }
}