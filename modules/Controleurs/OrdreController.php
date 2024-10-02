<?php

final class OrdreController
{
    public static string $titre = "Ordre";

    public function defaultAction()
    {
        
        Vue::montrer('ordre');

    }

}
