<link rel="stylesheet" href="Vues/assets/actions.css">
<?php if (isset($A_vue['onPlat'])): ?>
    <div class="confirmation">
        <h1>Confirmer la suppression</h1>
        <p>Êtes-vous sûr de vouloir supprimer ce plat ? Cette action est irréversible.</p>

        <form action="index.php?ctrl=Plat&action=supprimer&id=<?= htmlspecialchars($A_vue['id']); ?>&validation=true" method="POST">
            <input type="hidden" name="id" value="<?= htmlspecialchars($A_vue['id']); ?>">
            <button type="submit" class="btn-confirm">Oui, supprimer</button>
            <button type="button" class="btn-cancel" onclick="loadLister('Plat');">Annuler</button>
        </form>
    </div>
<?php endif; ?>

<?php if (isset($A_vue['onRepas'])): ?>
    <div class="confirmation">
        <h1>Confirmer la suppression</h1>
        <p>Êtes-vous sûr de vouloir supprimer ce repas ? Cette action est irréversible.</p>

        <form action="index.php?ctrl=Repas&action=supprimer&id=<?= htmlspecialchars($A_vue['id']); ?>&validation=true" method="POST">
            <input type="hidden" name="id" value="<?= htmlspecialchars($A_vue['id']); ?>">
            <button type="submit" class="btn-confirm">Oui, supprimer</button>
            <button type="button" class="btn-cancel" onclick="loadLister('Plat');">Annuler</button>
        </form>
    </div>
<?php endif; ?>

<?php if (isset($A_vue['onStructure'])): ?>
    <div class="confirmation">
        <h1>Confirmer la suppression</h1>
        <p>Êtes-vous sûr de vouloir supprimer cette structure ? Cette action est irréversible.</p>

        <form action="index.php?ctrl=Structure&action=supprimer&id=<?= htmlspecialchars($A_vue['id']); ?>&validation=true" method="POST">
            <input type="hidden" name="id" value="<?= htmlspecialchars($A_vue['id']); ?>">
            <button type="submit" class="btn-confirm">Oui, supprimer</button>
            <button type="button" class="btn-cancel" onclick="loadLister('Plat');">Annuler</button>
        </form>
    </div>
<?php endif; ?>

<?php if (isset($A_vue['onTenrac'])): ?>
    <div class="confirmation">
        <h1>Confirmer la suppression</h1>
        <p>Êtes-vous sûr de vouloir supprimer ce tenrac ? Cette action est irréversible.</p>

        <form action="index.php?ctrl=Tenrac&action=supprimer&id=<?= htmlspecialchars($A_vue['id']); ?>&validation=true" method="POST">
            <input type="hidden" name="id" value="<?= htmlspecialchars($A_vue['id']); ?>">
            <button type="submit" class="btn-confirm">Oui, supprimer</button>
            <button type="button" class="btn-cancel" onclick="loadLister('Plat');">Annuler</button>
        </form>
    </div>
<?php endif; ?>