<?php
final class PLatsController
{
    public static string $titre = "Plats";
    
    public function defaultAction()
    {
        Vue::montrer("plat", ""); 
    }
}