<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tenracs - En-tête</title>
    <link rel="stylesheet" href="Vues/assets/main.css">
</head>
<body id="buddy">
    <header id="tender">
        <input type="button" id="ouvreBtn" class="menuBouton"/>
        <a id="ordre" class="headMenu" href="?ctrl=ordre">L'Ordre</a>
        <a id="logo" class="headMenu" href="?ctrl=accueil">
            <img src='https://i.imgur.com/i1fZAtZ.png' alt="Logo">
        </a>
        <a id="compte" class="headMenu" href="?ctrl=compte">
            <img id="imgCompte" src="https://i.imgur.com/hjBCs33.png" alt="Compte">
        </a>
    </header>
    <nav class="menu" id="menu">
        <input type="button" id="fermeBtn" class="menuBouton">
        <ul>
            <li><a href="?ctrl=accueil">Accueil</a></li>
            <li><a href="?ctrl=ordre">L'Ordre</a></li>
            <li><a href="?ctrl=repas">Repas</a></li>
            <li><a href="?ctrl=recherche">Recherche</a></li>
            <li><a href="?ctrl=compte">Compte</a></li>
        </ul>
    </nav>
    <script src="Vues/assets/main.js"></script>
</body>
</html>
