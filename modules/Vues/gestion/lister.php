<?php if (isset($A_vue['onPlat'])): ?>
<h2>Liste des plats</h2>
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


<?php if (isset($A_vue['onRepas'])): ?>
    <!DOCTYPE html>
<html>
<head>
    <title>Liste des Repas</title>
</head>
<body>
    <h1>Liste des Repas</h1>
    <a href="index.php?ctrl=Repas&action=ajouter">Ajouter un Repas</a>
    <ul>
        <?php foreach ($A_vue['repas'] as $r) { ?>
            <li>
                <!-- Affichage du repas avec son ID, nom, date, adresse, et options de modification/suppression -->
                <?php echo "ID: " . $r['id'] . " | " . $r['nom'] . " - " . $r['datee'] . " - " . $r['adresse']; ?>
                <a href="index.php?ctrl=Repas&action=modifier&id=<?php echo $r['id']; ?>">Modifier</a>
                <a href="index.php?ctrl=Repas&action=supprimer&id=<?php echo $r['id']; ?>" onclick="return confirm('Voulez-vous vraiment supprimer ce repas ?')">Supprimer</a>
            </li>
        <?php } ?>
    </ul>
</body>
</html>


<?php endif; ?>
   