<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ordre des Tenrac</title>
    <link rel="stylesheet" href="Vues/assets/ordre.css">
</head>
<body>
    <?php Vue::montrer('standard/entete'); ?>

    <main>
        <h2>Ordre des Tenrac et Club</h2>
        <section id="ordre-description">
            <p>L'Ordre des Tenrac</p>
        </section>

        <section id="liste-ordre">
            <?php if (!empty($ordre)) : ?>
                <h3>L'Ordre des Tenracs</h3>
                <ul>
                    <?php foreach ($ordre as $structure) : ?>
                        <li>
                            <h4><?= htmlspecialchars($structure['nom']); ?></h4>
                            <p>Adresse : <?= htmlspecialchars($structure['adresse']); ?></p>
                            <p>Description : <?= htmlspecialchars($structure['description']); ?></p>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </section>

        <section id="liste-clubs">
            <?php if (!empty($clubs)) : ?>
                <h3>Clubs affiliés</h3>
                <ul>
                    <?php foreach ($clubs as $club) : ?>
                        <li>
                            <h4><?= htmlspecialchars($club['nom']); ?></h4>
                            <p>Adresse : <?= htmlspecialchars($club['adresse']); ?></p>
                            <p>Description : <?= htmlspecialchars($club['description']); ?></p>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else : ?>
                <p>Aucun club affilié pour le moment.</p>
            <?php endif; ?>
        </section>
    </main>

    <?php Vue::montrer('standard/pied'); ?>
    <script src="Vues/assets/main.js"></script>
</body>
</html>
