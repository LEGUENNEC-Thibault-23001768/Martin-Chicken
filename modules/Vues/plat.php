<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du Plat - Tenracs</title>
    <link rel="stylesheet" href="Vues/assets/plat.css">
</head>
<body>
    <?php Vue::montrer('standard/entete'); ?>

    <main>
        <h2>Détails du Plat</h2>
        <?php if (!empty($plat)) : ?>
            <section>
                <h3><?= htmlspecialchars($plat['nom']); ?></h3>
                <p>Ingrédients : <?= htmlspecialchars($plat['ingredients']); ?></p>
                <p>Sauces : <?= htmlspecialchars($plat['sauces']); ?></p>
                <p>Description : <?= htmlspecialchars($plat['description']); ?></p>
            </section>
        <?php else : ?>
            <p>Ce plat n'existe pas ou a été supprimé.</p>
        <?php endif; ?>
        <a href="index.php?ctrl=repas">Retour aux repas</a>
    </main>

    <?php Vue::montrer('standard/pied'); ?>
    <script src="Vues/assets/main.js"></script>
</body>
</html>
