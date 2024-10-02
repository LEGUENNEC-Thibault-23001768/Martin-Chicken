<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trouve ton club</title>
    <link rel="stylesheet" href="../Vues/assets/ordre.css">
    <script>
        function toggleDetails(id) {
            const details = document.getElementById(id);
            if (details.style.display === "none" || details.style.display === "") {
                details.style.display = "block";
            } else {
                details.style.display = "none";
            }
        }
    </script>
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
        <h1>Trouve ton club</h1>
    </header>

    <section class="club-container">
        <?php
        $clubs = [
            [
                "nom" => "AVIGNON",
                "adresse" => "32 Rue de la Raclette<br>84000 Avignon",
                "telephone" => "07 83 38 90 65",
                "activites" => "Bataille de boulettes de fromage, apnée dans de la raclette.",
                "denomination" => "Connu pour ses raclettes gluantes"
            ],
            [
                "nom" => "MARSEILLE",
                "adresse" => "123 Rue des Tenracs<br>13001 Marseille",
                "telephone" => "06 11 22 33 44",
                "activites" => "Combat d'épées de tenders, parcours ninja sur du fromage fondant.",
                "denomination" => "Le repaire des Vikings du poulet"
            ],
            [
                "nom" => "LYON",
                "adresse" => "456 Rue des Fromages<br>69001 Lyon",
                "telephone" => "07 99 88 77 66",
                "activites" => "Battle de danse sur la raclette tournante, course en sacs de fromages.",
                "denomination" => "Le temple de la folie fromagère"
            ],
            [
                "nom" => "PARIS",
                "adresse" => "789 Rue du Poulet<br>75001 Paris",
                "telephone" => "01 23 45 67 89",
                "activites" => "Natation dans sur Rivière de la raclette, lance poulet enflammé",
                "denomination" => "Maitre du tenders incontestable"
            ],
            [
                "nom" => "NICE",
                "adresse" => "22 Boulevard des Tendres<br>06000 Nice",
                "telephone" => "04 93 88 99 77",
                "activites" => "Pilation de la ville avec des battes de tenders",
                "denomination" => "Le sanctuaire des tenders"
            ],
            [
                "nom" => "BORDEAUX",
                "adresse" => "45 Avenue des Fromagiers<br>33000 Bordeaux",
                "telephone" => "05 56 66 77 88",
                "activites" => "Dégustation à l'aveugle de raclette, épreuve de résistance aux fondus bouillants.",
                "denomination" => "Capitale du fromage fondu."
            ],
        ];

        foreach ($clubs as $index => $club) {
            echo '<div class="club-card" onclick="toggleDetails(\'details-' . $index . '\')" style="cursor: pointer;">';
            echo '<h2>' . $club["nom"] . '</h2>';
            echo '<p>' . $club["adresse"] . '</p>';
            echo '<p>' . $club["telephone"] . '</p>';
            echo '<div id="details-' . $index . '" class="club-details" style="display: none;">';
            echo '<p><strong>Activités :</strong> ' . $club["activites"] . '</p>';
            echo '<p><strong>Dénomination :</strong> ' . $club["denomination"] . '</p>';
            echo '</div>';
            echo '</div>';
        }
        ?>
    </section>

    <footer>
        <p>Contactez-nous pour rejoindre l'un de nos clubs dératés !</p>
    </footer>
</body>

</html>
