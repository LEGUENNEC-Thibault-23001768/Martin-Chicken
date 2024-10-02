<!doctype html>
<html lang="fr">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title><?php echo isset($A_vue['titre']) ? $A_vue['titre'] : 'Titre par défaut'; ?></title>
    </head>
    <body>
        <?php Vue::montrer('standard/entete');?>
        <?php echo $A_vue['body'] ?>
        <?php Vue::montrer('standard/pied'); ?>

        <script src="Vues/assets/main.js"></script>
    </body>
</html>