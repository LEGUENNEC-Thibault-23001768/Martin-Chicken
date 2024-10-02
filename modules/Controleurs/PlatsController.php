<?php
final class ActualiteController
{
    public static string $titre = "Plats";
    
    public function defaultAction()
    {
        Vue::montrer("plat", ""); 
    }
}