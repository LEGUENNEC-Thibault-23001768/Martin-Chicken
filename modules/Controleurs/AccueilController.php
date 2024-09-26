<?php
final class AccueilController
{
    public static string $titre  = "gros zizi";
    public function defautAction()
    {
        Vue::montrer("accueil", ""); // à modifier par le vrai accueil
    }
}