<?php if (isset($A_vue['error'])): ?>
    <p style="color: red;"><?php echo $A_vue['error']; ?></p>
<?php endif; ?>

<?php if (isset($A_vue['onPlat'])): ?>
    <?php if ($A_vue['plat']): ?>
        <form action="index.php?ctrl=Plat&action=modifier&id=<?php echo $A_vue['plat']['id']; ?>" method="POST">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        <input type="hidden" name="id" value="<?= $A_vue['plat']['id'] ?>">

        <label for="nom">Nom du plat:</label>
        <input type="text" id="nom" name="nom" value="<?= $A_vue['plat']['nom'] ?>" required>

        <label for="presence">C'est HALAL? :</label>
        <input type="checkbox" name="presence" <?= $A_vue['plat']['presence'] ? 'checked' : '' ?>><br>

        <label for="ingredients">Ingrédients :</label><br>
        <?php if (isset($A_vue['ingredients'])): ?>
            <?php foreach ($A_vue['ingredients'] as $ingredient): ?>
                <?php $checked = in_array($ingredient['id'], array_column($A_vue['ingredientsPlat'], 'id')) ? 'checked' : ''; ?>
                <input type="checkbox" name="ingredients[]" value="<?php echo $ingredient['id']; ?>" <?php echo $checked; ?>>
                <?php echo htmlspecialchars($ingredient['nom']); ?><br>
            <?php endforeach; ?>
        <?php endif; ?>

        <label for="sauces">Sauces : </label><br>
        <?php if (isset($A_vue['sauces'])): ?>
            <?php foreach ($A_vue['sauces'] as $sauce): ?>
                <?php $checked = in_array($sauce['id'], array_column($A_vue['saucesPlat'], 'id')) ? 'checked' : ''; ?>
                <input type="checkbox" name="sauces[]" value="<?php echo $sauce['id']; ?>" <?php echo $checked; ?>>
                <?php echo htmlspecialchars($sauce['nom']); ?><br>
            <?php endforeach; ?>
        <?php endif; ?>

        <button type="submit">Modifier le plat</button>
    </form>
    <?php else: ?>
        <p>Plat non trouvé.</p>
    <?php endif; ?>
<?php endif; ?>


<?php if (isset($A_vue['onRepas'])): ?>
    <h1>Modifier un Repas</h1>
    <?php if (isset($A_vue['repas'])): ?>
        <form action="index.php?ctrl=Repas&action=modifier" method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <input type="hidden" name="id" value="<?= $A_vue['repas']['id'] ?>">

            <label for="nom">Nom du repas:</label>
            <input type="text" id="nom" name="nom" value="<?= $A_vue['repas']['nom'] ?>" required>
            
            <label for="date">Date:</label>
            <input type="date" name="date" value="<?= $A_vue['repas']['date'] ?>" required><br>

            <label for="adresse">Adresse:</label>
            <input type="text" name="adresse" value="<?= $A_vue['repas']['adresse'] ?>" required><br>

            <label>Plats :</label><br>
            <?php foreach ($A_vue['plats'] as $p): ?>
            <div class="form-check">
                <?php
                $isChecked = false;
                $ingredients = '';
                foreach ($A_vue['platsRepas'] as $platRepas) {
                    if ($platRepas['id'] == $p['id']) {
                        $isChecked = true;
                        $ingredients = $platRepas['ingredients'] ?? '';
                        break;
                    }
                }
                ?>
                <input class="form-check-input" type="checkbox" name="plats[]" value="<?php echo $p['id']; ?>" id="plat_<?php echo $p['id']; ?>"
                    <?php echo $isChecked ? 'checked' : ''; ?>>
                <label class="form-check-label" for="plat_<?php echo $p['id']; ?>">
                    <?php echo htmlspecialchars($p['nom']); ?>
                    <?php if (!empty($ingredients)): ?>
                        <small>(<?php echo htmlspecialchars($ingredients); ?>)</small>
                    <?php endif; ?>
                </label>
            </div>
        <?php endforeach; ?>
            
            <button type="submit">Modifier le repas</button>
        </form>
    <?php else: ?>
        <p>Repas non trouvé.</p>
    <?php endif; ?>
<?php endif; ?>


<?php if (isset($A_vue['onStructure'])): ?>
    <h1>Modifier une Structure</h1>

<?php if (isset($A_vue['error'])): ?>
    <p style="color: red;"><?php echo $A_vue['error']; ?></p>
<?php endif; ?>

<?php if ($A_vue['structure']): ?>
<form action="index.php?ctrl=Structure&action=modifier" method="POST">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
    <input type="hidden" name="id" value="<?php echo $A_vue['structure']['Id']; ?>">

    <label for="type">Type:</label>
    <input type="text" id="type" value="<?php echo htmlspecialchars($A_vue['structure']['Type']); ?>" readonly><br>

    <label for="nom">Nom:</label>
    <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($A_vue['structure']['Nom']); ?>" required><br>

    <label for="adresse">Adresse:</label>
    <input type="text" id="adresse" name="adresse" value="<?php echo htmlspecialchars($A_vue['structure']['Adresse']); ?>" required><br>

    <button type="submit">Modifier la structure</button>
</form>
<?php else: ?>
    <p>Structure non trouvée.</p>
<?php endif; ?>


    <?php endif; ?>

<?php if (isset($A_vue['onTenrac'])): ?>


    <h1>Modifier un Tenrac</h1>

<?php if (isset($A_vue['error'])): ?>
    <p style="color: red;"><?php echo $A_vue['error']; ?></p>
<?php endif; ?>

<form action="index.php?ctrl=Tenrac&action=modifier" method="POST">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
    <input type="hidden" name="id" value="<?php echo $A_vue['tenrac']['id']; ?>">

    <label for="code_personnel">Code Personnel:</label>
    <input type="text" id="code_personnel" name="code_personnel" value="<?php echo htmlspecialchars($A_vue['tenrac']['code_personnel']); ?>" required><br>

    <label for="nom">Nom:</label>
    <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($A_vue['tenrac']['nom']); ?>" required><br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($A_vue['tenrac']['email']); ?>" required><br>

    <label for="numero">Numéro:</label>
    <input type="text" id="numero" name="numero" value="<?php echo htmlspecialchars($A_vue['tenrac']['numero']); ?>"><br>

    <label for="adresse">Adresse:</label>
    <input type="text" id="adresse" name="adresse" value="<?php echo htmlspecialchars($A_vue['tenrac']['adresse']); ?>"><br>

    <label for="grade">Grade:</label>
    <select id="grade" name="grade" required>
        <?php
        $grades = ['Affilié', 'Sympathisant', 'Adhérent', 'Chevalier / Dame', 'Grand Chevalier / Haute Dame', 'Commandeur', 'Grand \'Croix'];
        foreach ($grades as $grade):
            $selected = ($A_vue['tenrac']['Grade'] == $grade) ? 'selected' : '';
        ?>
            <option value="<?php echo $grade; ?>" <?php echo $selected; ?>><?php echo $grade; ?></option>
        <?php endforeach; ?>
    </select><br>

    <label for="rang">Rang:</label>
    <select id="rang" name="rang">
        <option value="">Aucun</option>
        <?php
        $rangs = ['Novice', 'Compagnon'];
        foreach ($rangs as $rang):
            $selected = ($A_vue['tenrac']['Rang'] == $rang) ? 'selected' : '';
        ?>
            <option value="<?php echo $rang; ?>" <?php echo $selected; ?>><?php echo $rang; ?></option>
        <?php endforeach; ?>
    </select><br>

    <label for="titre">Titre:</label>
    <select id="titre" name="titre">
        <option value="">Aucun</option>
        <?php
        $titres = ['Philanthrope', 'Protecteur', 'Honorable'];
        foreach ($titres as $titre):
            $selected = ($A_vue['tenrac']['Titre'] == $titre) ? 'selected' : '';
        ?>
            <option value="<?php echo $titre; ?>" <?php echo $selected; ?>><?php echo $titre; ?></option>
        <?php endforeach; ?>
    </select><br>

    <label for="dignite">Dignité:</label>
    <select id="dignite" name="dignite">
        <option value="">Aucune</option>
        <?php
        $dignites = ['Maitre', 'Grand Chancelier', 'Grand Maitre'];
        foreach ($dignites as $dignite):
            $selected = ($A_vue['tenrac']['Dignite'] == $dignite) ? 'selected' : '';
        ?>
            <option value="<?php echo $dignite; ?>" <?php echo $selected; ?>><?php echo $dignite; ?></option>
        <?php endforeach; ?>
    </select><br>

    <label for="structure_id">Structure:</label>
    <select id="structure_id" name="structure_id">
        <option value="">Aucune</option>
        <?php foreach ($A_vue['structures'] as $structure): ?>
            <?php $selected = ($A_vue['tenrac']['structure_id'] == $structure['id']) ? 'selected' : ''; ?>
            <option value="<?php echo $structure['id']; ?>" <?php echo $selected; ?>>
                <?php echo htmlspecialchars($structure['nom']); ?>
            </option>
        <?php endforeach; ?>
    </select><br>

    <button type="submit">Modifier le Tenrac</button>
</form>
<?php else: ?>
    <p>Tenrac non trouvé.</p>
<?php endif; ?>
