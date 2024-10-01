<?php
// Ce fichier est le point d'entrée de votre application
header_remove("Server");
header_remove("Via");   
header_remove("X-Powered-By");
header_remove("Host");
session_start();

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

require 'Noyau/autoloader.php';


$S_controleur = isset($_GET['ctrl']) ? $_GET['ctrl'] : null;
$S_action = isset($_GET['action']) ? $_GET['action'] : null;

Vue::ouvrirTampon(); //  /Noyau/Vue.php : on ouvre le tampon d'affichage, les contrôleurs qui appellent des vues les mettront dedans
$O_controleur = new Controleur($S_controleur, $S_action);
$O_controleur->executer();

// Les différentes sous-vues ont été "crachées" danxs le tampon d'affichage, on les récupère
$contenuPourAffichage = Vue::recupererContenuTampon();

// Si c'est une requête AJAX, renvoie uniquement le contenu partiel
if (!empty($_GET['ajax']) && $_GET['ajax'] === 'true') {
    echo $contenuPourAffichage;  // On renvoie uniquement le contenu partiel
} else {
    // Sinon, on affiche le gabarit complet
    Vue::montrer('gabarit', [
        'body' => $contenuPourAffichage,
        'titre' => $O_controleur->getUrlDecortique()['controleur']::$titre
    ]);
}
