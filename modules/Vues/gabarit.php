<!doctype html>
<html lang="fr">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" href="Vues/assets/main.css">
        <title><?php echo $A_vue['titre']?></title>
    </head>
    <body>
        <?php //Vue::montrer('standard/entete');?>
        <?php echo $A_vue['body'] ?>
        <?php Vue::montrer('standard/pied'); ?>

        <script src="Vues/assets/main.js"></script>
    </body>
</html>