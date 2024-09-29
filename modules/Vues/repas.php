<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Repas à venir - Tenracs</title>
    <link rel="stylesheet" href="Vues/assets/repas.css">
</head>
<body>
    <?php Vue::montrer('standard/entete'); ?>

    <main>
        <h2>Repas à venir</h2>
        <ul>
            <?php if (!empty($repas)) : ?>
                <?php foreach ($repas as $repasItem) : ?>
                    <li>
                        <h3><?= htmlspecialchars($repasItem['titre']); ?> - <?= htmlspecialchars($repasItem['date']); ?></h3>
                        <p><?= htmlspecialchars($repasItem['description']); ?></p>
                        <a href="index.php?ctrl=plat&id=<?= htmlspecialchars($repasItem['id_plat']); ?>">Voir le plat</a>
                    </li>
                <?php endforeach; ?>
            <?php else : ?>
                <li>Aucun repas prévu pour le moment.</li>
            <?php endif; ?>
        </ul>
    </main>

    <?php Vue::montrer('standard/pied'); ?>
    <script src="Vues/assets/main.js"></script>
</body>
</html>
