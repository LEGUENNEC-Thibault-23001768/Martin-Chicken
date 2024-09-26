<?php if (isset($A_vue['onPlat'])): ?>
    <?php if ($plat): ?>
    <form action="index.php?ctrl=Plat&action=modifier" method="POST">
        <input type="hidden" name="id" value="<?= $plat['Id'] ?>">

        <label for="nom">Nom du plat:</label>
        <input type="text" id="nom" name="nom" value="<?= $plat['Nom'] ?>" required>

        <label for="repas_id">ID du repas:</label>
        <input type="number" id="repas_id" name="repas_id" value="<?= $plat['Repas_Id'] ?>" required>

        <button type="submit">Modifier le plat</button>
    </form>
    <?php else: ?>
        <p>Plat non trouvé.</p>
    <?php endif; ?>
<?php endif; ?>



<?php if (isset($A_vue['onRepas'])): ?>
    <!DOCTYPE html>
<html>
<head>
    <title>Modifier un Repas</title>
</head>
<body>
    <h1>Modifier le Repas</h1>
    <?php if (isset($A_vue['repas'])) { ?>
        <form action="index.php?ctrl=Repas&action=modifier" method="POST">
            <!-- Champ caché pour l'ID du repas -->
            <input type="hidden" name="id" value="<?php echo $A_vue['repas']['id']; ?>">

            <label for="nom">Nom:</label>
            <input type="text" name="nom" value="<?php echo $A_vue['repas']['nom']; ?>" required><br>

            <label for="date">Date:</label>
            <input type="date" name="date" value="<?php echo $A_vue['repas']['datee']; ?>" required><br>

            <label for="adresse">Adresse:</label>
            <input type="text" name="adresse" value="<?php echo $A_vue['repas']['adresse']; ?>" required><br>

            <label for="presence">Présence:</label>
            <input type="checkbox" name="presence" <?php echo $A_vue['repas']['presence'] ? 'checked' : ''; ?>><br>

            <button type="submit">Modifier</button>
        </form>
    <?php } else { ?>
        <p>Repas introuvable.</p>
    <?php } ?>
</body>
</html>



<?php endif; ?>

