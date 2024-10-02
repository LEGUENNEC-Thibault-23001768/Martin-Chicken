<?php
final class ReunionController
{
    public static string $titre  = "Reunion";
    
    public function defaultAction()
    {
        Vue::montrer("tenracs", "");
    }
}