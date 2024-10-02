<?php
final class HistoireController
{
    public static string $titre = "Histoire";

    public function defaultAction()
    {
        Vue::montrer("histoire", "");
    }

}