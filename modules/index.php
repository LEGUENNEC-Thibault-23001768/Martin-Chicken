<?php
// Ce fichier est le point d'entrée de votre application
session_save_path(__DIR__ . "/sessions");
session_start();
require 'Noyau/autoloader.php';

$S_controleur = isset($_GET['ctrl']) ? $_GET['ctrl'] : null;
$S_action = isset($_GET['action']) ? $_GET['action'] : null;

Vue::ouvrirTampon(); //  /Noyau/Vue.php : on ouvre le tampon d'affichage, les contrôleurs qui appellent des vues les mettront dedans
$O_controleur = new Controleur($S_controleur, $S_action);
$O_controleur->executer();

// Les différentes sous-vues ont été "crachées" dans le tampon d'affichage, on les récupère
$contenuPourAffichage = Vue::recupererContenuTampon();
    Vue::montrer('gabarit', [
        'body' => $contenuPourAffichage,
        'titre' => $O_controleur->getUrlDecortique()['controleur']::$titre
    ]);

