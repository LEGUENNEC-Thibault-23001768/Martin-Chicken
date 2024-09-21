<?php if (isset($A_vue['actionPlat'])): ?>
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