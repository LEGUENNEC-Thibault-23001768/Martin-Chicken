<?php if (isset($A_vue['error'])): ?>
    <p style="color: red;"><?php echo $A_vue['error']; ?></p>
<?php endif; ?>

<?php if (isset($A_vue['onPlat'])): ?>
        <section class="cards">
            <?php foreach ($A_vue['plats'] as $plat): ?>
                <div class="card">
                    <section class="contenu">
                        <p>ID : <?= $plat['id'] ?></p>
                        <p>Nom : <?= $plat['nom'] ?></p>
                        <p>Legumes : <?= $plat['presence'] ?></p>
                    </section>
                    <section class="actions">
                        <button class="boutonAction" onclick="loadModifier('Plat', <?= $plat['id'] ?>)">Modifier</button>
                        <button class="boutonAction" onclick="loadSupprimer('Plat', <?= $plat['id'] ?>)">Supprimer</button>
                    </section>
                </div>
            <?php endforeach; ?>
            <button class="boutonAdd" onclick="loadAjouter('Plat')">+</button>
        </section>
<?php endif; ?>


<?php if (isset($A_vue['onRepas'])): ?>
    <section class="cards">
            <?php foreach ($A_vue['repas'] as $r): ?>
                <div class="card">
                    <section class="contenu">
                        <p>ID : <?php echo htmlspecialchars($r['id']); ?></p>
                        <p>Nom : <?php echo htmlspecialchars($r['nom']); ?></p>
                        <p>Date : <?php echo htmlspecialchars($r['date']); ?></p>
                        <p>Adresse : <?php echo htmlspecialchars($r['adresse']); ?></p>
                        <p>Plats : <?php echo htmlspecialchars($r['plats'] ?? 'Aucun plat associé'); ?></p>
                    </section>
                    <section class="actions">
                        <button class="boutonAction" onclick="loadModifier('Plat', <?= $plat['id'] ?>)">Modifier</button>
                        <button class="boutonAction" onclick="loadSupprimer('Plat', <?= $plat['id'] ?>)">Supprimer</button>
                    </section>
                </div>
            <?php endforeach; ?>
            <button class="boutonAdd" onclick="loadAjouter('Repas')">+</button>
    </section>
<?php if (empty($A_vue['repas'])): ?>
    <p>Aucun repas trouvé.</p>
<?php endif; ?>
<?php endif; ?>

<?php if (isset($A_vue['onStructure'])): ?>
    <section class="cards">
        <?php foreach ($A_vue['structures'] as $tenrac): ?>
            <div class="card">
                <section class="contenu">
                    <p>Type : <?php echo htmlspecialchars($tenrac['type']); ?></p>
                    <p>Nom : <?php echo htmlspecialchars($tenrac['nom']); ?></p>
                    <p>Adresse : <?php echo htmlspecialchars($tenrac['adresse']); ?></p>
                </section>
                <section class="actions">
                    <button class="boutonAction" onclick="loadModifier('Structure', <?= $tenrac['id'] ?>)">Modifier</button>
                    <?php if ($tenrac['type'] === 'Club'): ?>
                        <button class="boutonAction" onclick="loadSupprimer('Structure', <?= $tenrac['id'] ?>)">Supprimer</button>
                    <?php endif; ?>
                </section>
            </div>
        <?php endforeach; ?>
        <button class="boutonAdd" onclick="loadAjouter('Structure')">+</button>
    </section>
<?php endif; ?>


<?php if (isset($A_vue['onTenrac'])): ?>
    <section class="cards">
        <?php foreach ($A_vue['tenracs'] as $tenrac): ?>
            <div class="card">
                <section class="contenu">
                    <p>Code Personnel : <?php echo htmlspecialchars($tenrac['code_personnel']); ?></p>
                    <p>Nom : <?php echo htmlspecialchars($tenrac['nom']); ?></p>
                    <p>Email : <?php echo htmlspecialchars($tenrac['email']); ?></p>
                    <p>Grade : <?php echo htmlspecialchars($tenrac['grade']); ?></p>
                    <p>Structure : <?php echo htmlspecialchars($tenrac['structure_nom']); ?></p>
                </section>
                <section class="actions">
                    <button class="boutonAction" onclick="loadModifier('Tenrac', <?= $tenrac['id'] ?>)">Modifier</button>
                    <button class="boutonAction" onclick="loadSupprimer('Tenrac', <?= $tenrac['id'] ?>)">Supprimer</button>
                </section>
            </div>
        <?php endforeach; ?>
        <button class="boutonAdd" onclick="loadAjouter('Structure')">+</button>
    </section>

    <?php endif; ?>