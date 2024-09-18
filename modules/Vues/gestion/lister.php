<?php if (isset($A_vue['actionPlat'])): ?>
h2>Liste des plats</h2>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>ID du repas</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($plats as $plat): ?>
        <tr>
            <td><?= $plat['Id'] ?></td>
            <td><?= $plat['Nom'] ?></td>
            <td><?= $plat['Repas_Id'] ?></td>
            <td>
                <a href="index.php?ctrl=Plat&action=modifier&id=<?= $plat['Id'] ?>">Modifier</a>
                <a href="index.php?ctrl=Plat&action=supprimer&id=<?= $plat['Id'] ?>">Supprimer</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<a href="index.php?ctrl=Plat&action=ajouter">Ajouter un plat</a>
<?php endif; ?>