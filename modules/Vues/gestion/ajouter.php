
<?php if (isset($A_vue['actionPlat'])): ?>
    <form action="index.php?ctrl=Plat&action=ajouter" method="POST">
        <label for="nom">Nom du plat:</label>
        <input type="text" id="nom" name="nom" required>
    
        <label for="repas_id">ID du repas:</label>
        <input type="number" id="repas_id" name="repas_id" required>
    
        <button type="submit">Ajouter le plat</button>
    </form>
<?php endif; ?>

<?php if (isset($A_vue['actionRepas'])): ?>
    <form action="index.php?ctrl=Repas&action=ajouter" method="POST">
        <label for="date">Date du repas:</label>
        <input type="date" id="date" name="date" required>
    
        <button type="submit">Ajouter le repas</button>
    </form>
<?php endif; ?>