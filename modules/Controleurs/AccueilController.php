<?php
final class AccueilController
{
    public function defautAction()
    {
        Vue::montrer("auth/login", ""); // à modifier par le vrai accueil
    }
}
?>