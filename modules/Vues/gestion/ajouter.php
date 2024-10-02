<link rel="stylesheet" href="Vues/assets/actions.css">

<?php if (isset($A_vue['error'])): ?>
        <p style="color: red;"><?php echo $A_vue['error']; ?></p>
<?php endif; ?>

<?php if (isset($A_vue['onPlat'])): ?>
    <h1>Ajouter un Plat</h1>
    <form action="index.php?ctrl=Plat&action=ajouter" method="POST">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        <label for="nom">Nom du plat :</label>
        <input type="text" name="nom" required><br>

        <label for="presence">C'est HALAL? :</label>
        <input type="checkbox" name="presence"><br>

        <label for="ingredients">Ingrédients :</label><br>
        <?php if (isset($A_vue['ingredients'])): ?>
            <?php foreach ($A_vue['ingredients'] as $ingredient): ?>
                <input type="checkbox" name="ingredients[]" value="<?php echo $ingredient['id']; ?>">
                <?php echo htmlspecialchars($ingredient['nom']); ?><br>
            <?php endforeach; ?>
        <?php endif; ?>

        <label for="sauces">Sauces : </label><br>
        <?php if (isset($A_vue['sauces'])): ?>
            <?php foreach ($A_vue['sauces'] as $sauce): ?>
                <input type="checkbox" name="sauces[]" value="<?php echo $sauce['id']; ?>">
                <?php echo htmlspecialchars($sauce['nom']); ?><br>
            <?php endforeach; ?>
        <?php endif; ?>

        <button type="submit">Ajouter le plat</button>
    </form>
<?php endif; ?>
    
<?php if (isset($A_vue['onRepas'])): ?>
    <form action="index.php?ctrl=Repas&action=ajouter" method="POST">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        <label for="nom">Nom du repas:</label>
        <input type="text" id="nom" name="nom" required>
        
        <label for="date">Date:</label>
        <input type="date" name="date" required><br>

        <label for="adresse">Adresse:</label>
        <input type="text" name="adresse" required><br>

        
        <label>Plats:</label><br>
        <?php foreach ($A_vue['plats'] as $plat): ?>
            <input type="radio" name="plat_id" value="<?php echo $plat['id']; ?>" id="plat_<?php echo $plat['id']; ?>" required>
            <label for="plat_<?php echo $plat['id']; ?>">
                <?php echo htmlspecialchars($plat['nom'] . ' - ' . $plat['ingredients']); ?>
            </label><br>
        <?php endforeach; ?>

        <button type="submit">Ajouter le repas</button>
    </form>
    
<?php endif; ?>


<?php if (isset($A_vue['onStructure'])): ?>

    <h1>Ajouter une Structure</h1>

<?php if (isset($A_vue['error'])): ?>
    <p style="color: red;"><?php echo $A_vue['error']; ?></p>
<?php endif; ?>

<form action="index.php?ctrl=Structure&action=ajouter" method="POST">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
    <label for="type">Type:</label>
    <select name="type" id="type" required>
        <option value="Ordre">Ordre</option>
        <option value="Club">Club</option>
    </select><br>

    <label for="nom">Nom:</label>
    <input type="text" id="nom" name="nom" required><br>

    <label for="adresse">Adresse:</label>
    <input type="text" id="adresse" name="adresse" required><br>

    <button type="submit">Ajouter la structure</button>
</form>

    <?php endif; ?>



<?php if (isset($A_vue['onTenrac'])): ?>
    <h1>Ajouter un Tenrac</h1>
<?php if (isset($A_vue['error'])): ?>
    <p style="color: red;"><?php echo $A_vue['error']; ?></p>
<?php endif; ?>

<form action="index.php?ctrl=Tenrac&action=ajouter" method="POST">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
    <label for="code_personnel">Code Personnel:</label>
    <input type="text" id="code_personnel" name="code_personnel" required><br>

    <label for="nom">Nom:</label>
    <input type="text" id="nom" name="nom" required><br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required><br>

    <label for="numero">Numéro:</label>
    <input type="text" id="numero" name="numero"><br>

    <label for="adresse">Adresse:</label>
    <input type="text" id="adresse" name="adresse"><br>

    <label for="grade">Grade:</label>
    <select id="grade" name="grade" required>
        <option value="Affilié">Affilié</option>
        <option value="Sympathisant">Sympathisant</option>
        <option value="Adhérent">Adhérent</option>
        <option value="Chevalier / Dame">Chevalier / Dame</option>
        <option value="Grand Chevalier / Haute Dame">Grand Chevalier / Haute Dame</option>
        <option value="Commandeur">Commandeur</option>
        <option value="Grand 'Croix">Grand 'Croix</option>
    </select><br>

    <label for="rang">Rang:</label>
    <select id="rang" name="rang">
        <option value="">Aucun</option>
        <option value="Novice">Novice</option>
        <option value="Compagnon">Compagnon</option>
    </select><br>

    <label for="titre">Titre:</label>
    <select id="titre" name="titre">
        <option value="">Aucun</option>
        <option value="Philanthrope">Philanthrope</option>
        <option value="Protecteur">Protecteur</option>
        <option value="Honorable">Honorable</option>
    </select><br>

    <label for="dignite">Dignité:</label>
    <select id="dignite" name="dignite">
        <option value="">Aucune</option>
        <option value="Maitre">Maitre</option>
        <option value="Grand Chancelier">Grand Chancelier</option>
        <option value="Grand Maitre">Grand Maitre</option>
    </select><br>

        <label for="structure_id">Structure:</label>
    <select id="structure_id" name="structure_id">
        <option value="">Sélectionnez une structure</option>
        <?php if (isset($A_vue['structures']) && !empty($A_vue['structures'])): ?>
            <?php foreach ($A_vue['structures'] as $structure): ?>
                <option value="<?php echo $structure['id']; ?>">
                    <?php echo htmlspecialchars($structure['type'] . ' - ' . $structure['nom']); ?>
                </option>
            <?php endforeach; ?>
        <?php else: ?>
            <option value="" disabled>Aucune structure disponible</option>
        <?php endif; ?>
    </select><br>

    <button type="submit">Ajouter le Tenrac</button>
</form>
<?php endif; ?>