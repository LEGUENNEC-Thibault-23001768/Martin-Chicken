<?php if (isset($A_vue['error'])): ?>
    <p style="color: red;"><?php echo $A_vue['error']; ?></p>
<?php endif; ?>

<?php if (isset($A_vue['onPlat'])): ?>
<h2>Liste des plats</h2>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Legume</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($A_vue['plats'] as $plat): ?>
        <tr>
            <td><?= $plat['id'] ?></td>
            <td><?= $plat['nom'] ?></td>
            <td><?= $plat['presence'] ?></td>
            <td>
                <a href="index.php?ctrl=Plat&action=modifier&id=<?= $plat['id'] ?>">Modifier</a>
                <a href="index.php?ctrl=Plat&action=supprimer&id=<?= $plat['id'] ?>">Supprimer</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<a href="index.php?ctrl=Plat&action=ajouter">Ajouter un plat</a>
<?php endif; ?>


<?php if (isset($A_vue['onRepas'])): ?>
<h1>Liste des Repas</h1>
<a href="index.php?ctrl=Repas&action=ajouter" class="btn btn-primary">Ajouter un Repas</a>

<!--
<form action="index.php" method="GET" class="mb-3 mt-3">
    <input type="hidden" name="ctrl" value="Repas">
    <input type="hidden" name="action" value="rechercher">
    <input type="text" name="terme" placeholder="Rechercher un repas...">
    <button type="submit" class="btn btn-secondary">Rechercher</button>
</form> <-->
<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Date</th>
            <th>Adresse</th>
            <th>Plats</th>
            <th>Actions</th>
        </tr>
    </thead>
    <?php foreach ($A_vue['repas'] as $r): ?>
        <tr>
            <td><?php echo htmlspecialchars($r['id']); ?></td>
            <td><?php echo htmlspecialchars($r['nom']); ?></td>
            <td><?php echo htmlspecialchars($r['date']); ?></td>
            <td><?php echo htmlspecialchars($r['adresse']); ?></td>
            <td><?php echo htmlspecialchars($r['plats'] ?? 'Aucun plat associé'); ?></td>
            <td>
                <a href="index.php?ctrl=Repas&action=modifier&id=<?php echo $r['id']; ?>" class="btn btn-sm btn-warning">Modifier</a>
                <a href="index.php?ctrl=Repas&action=supprimer&id=<?php echo $r['id']; ?>" 
                    onclick="return confirm('Voulez-vous vraiment supprimer ce repas ?')" 
                    class="btn btn-sm btn-danger">Supprimer</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<?php if (empty($A_vue['repas'])): ?>
    <p>Aucun repas trouvé.</p>
<?php endif; ?>

<?php endif; ?>

<?php if (isset($A_vue['onStructure'])): ?>
    <h1>Liste des Structures</h1>

<a href="index.php?ctrl=Structure&action=ajouter">Ajouter une structure</a>

<table>
    <tr>
        <th>Type</th>
        <th>Nom</th>
        <th>Adresse</th>
        <th>Actions</th>
    </tr>

    <?php foreach ($A_vue['structures'] as $structure): ?>
    <tr>
        <td><?php echo htmlspecialchars($structure['type']); ?></td>
        <td><?php echo htmlspecialchars($structure['nom']); ?></td>
        <td><?php echo htmlspecialchars($structure['adresse']); ?></td>
        <td>
            <a href="index.php?ctrl=Structure&action=modifier&id=<?php echo $structure['id']; ?>">Modifier</a>
            <?php if ($structure['type'] === 'Club'): ?>
                <a href="index.php?ctrl=Structure&action=supprimer&id=<?php echo $structure['id']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce club ?');">Supprimer</a>
            <?php endif; ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<?php endif; ?>


<?php if (isset($A_vue['onTenrac'])): ?>
    <h1>Liste des Tenracs</h1>

<a href="index.php?ctrl=Tenrac&action=ajouter">Ajouter un Tenrac</a>

<table>
    <tr>
        <th>Code Personnel</th>
        <th>Nom</th>
        <th>Email</th>
        <th>Grade</th>
        <th>Structure</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($A_vue['tenracs'] as $tenrac): ?>
    <tr>
        <td><?php echo htmlspecialchars($tenrac['code_personnel']); ?></td>
        <td><?php echo htmlspecialchars($tenrac['nom']); ?></td>
        <td><?php echo htmlspecialchars($tenrac['email']); ?></td>
        <td><?php echo htmlspecialchars($tenrac['grade']); ?></td>
        <td><?php echo htmlspecialchars($tenrac['structure_som']); ?></td>
        <td>
            <a href="index.php?ctrl=Tenrac&action=modifier&id=<?php echo $tenrac['id']; ?>">Modifier</a>
            <a href="index.php?ctrl=Tenrac&action=supprimer&id=<?php echo $tenrac['id']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce Tenrac ?');">Supprimer</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>


    <?php endif; ?>