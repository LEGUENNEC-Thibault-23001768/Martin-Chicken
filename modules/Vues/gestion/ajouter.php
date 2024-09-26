
<?php if (isset($A_vue['onPlat'])): ?>
    <form action="index.php?ctrl=Plat&action=ajouter" method="POST">
        <label for="nom">Nom du plat:</label>
        <input type="text" id="nom" name="nom" required>
    
        <label for="repas_id">ID du repas:</label>
        <input type="number" id="repas_id" name="repas_id" required>
    
        <button type="submit">Ajouter le plat</button>
    </form>
<?php endif; ?>

<?php if (isset($A_vue['onRepas'])): ?>
<html>
<head>
    <title>Ajouter un Repas</title>
</head>
<body>
    <h1>Ajouter un Repas</h1>
    <?php if (isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
    <form action="index.php?ctrl=Repas&action=ajouter" method="POST">
        <label for="nom">Nom:</label>
        <input type="text" name="nom" required><br>

        <label for="date">Date:</label>
        <input type="date" name="date" required><br>

        <label for="adresse">Adresse:</label>
        <input type="text" name="adresse" required><br>

        <label for="presence">Présence:</label>
        <input type="checkbox" name="presence"><br>

        <button type="submit">Ajouter</button>
    </form>
</body>
</html>

<?php endif; ?>