<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Événements Tenracs</title>
    <link rel="stylesheet" href="../Vues/assets/tenracs.css">
</head>
<head>
    <link rel="icon" href="assets/favicon.ico" type="image/x-icon">
    <link rel="icon" href="assets/favicon-32x32.png" sizes="32x32" type="image/png">
    <link rel="icon" href="assets/favicon-16x16.png" sizes="16x16" type="image/png">
    <link rel="apple-touch-icon" href="assets/apple-touch-icon.png">
    <link rel="manifest" href="assets/site.webmanifest">
</head>
<body>
    <header>
        <h1>Prochains événements secrets des Tenracs</h1>
    </header>

    <section class="event-container">
        <?php
        $events = [
            [
                "nom" => "Festin de la Princesse Cremière",
                "adresse" => "Avignon",
                "date" => "À venir",
                "presente" => "Chevalier DoubleTender92"
            ],
            [
                "nom" => "Festin de la Raclette Brulante",
                "adresse" => "Marseille",
                "date" => "À venir",
                "presente" => "Dame CremièreRoyale"
            ],
            [
                "nom" => "Nuit des Fromages doux",
                "adresse" => "Lyon",
                "date" => "À venir",
                "presente" => "Chevalier TenderCramé"
            ],
            [
                "nom" => "Pluie de fromage rapés",
                "adresse" => "Paris",
                "date" => "À venir",
                "presente" => "Dame RaclettePrestigeMax"
            ],
            [
                "nom" => "Couché de soleil camembert",
                "adresse" => "Nice",
                "date" => "À venir",
                "presente" => "Chevalier Charlemagne"
            ],  
            [
                "nom" => "Concert de Gouda92i",
                "adresse" => "Bordeaux",
                "date" => "À venir",
                "presente" => "Dame TartareCibouletteDeKefta"
            ],
        ];

        // Boucle pour afficher chaque événement
        foreach ($events as $event) {
            echo '<div class="event-card">';
            echo '<h2>' . $event["nom"] . '</h2>';
            echo '<p><strong>Adresse :</strong> ' . $event["adresse"] . '</p>';
            echo '<p><strong>Date :</strong> ' . $event["date"] . '</p>';
            echo '<p><strong>Sous l\'égide de :</strong> ' . $event["presente"] . '</p>';
            echo '</div>';
        }
        ?>
    </section>

    <footer>
        <p>Rejoignez-nous pour les festins les plus exclusifs et secrets !</p>
    </footer>
</body>

</html>
