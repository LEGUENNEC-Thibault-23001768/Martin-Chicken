<?php
final class ActualiteController
{
    public static string $titre = "Actualite";
    
    public function defaultAction()
    {
        Vue::montrer("actualite", ""); 
    }
}