<?php

use data\superGlobal\Get;
use data\superGlobal\Post;

include __DIR__ . '/../src/load.php';

if(isset(Post::$action)) {
    try {
        // Si le routage se passe bien, rediriger vers
        include __DIR__ . '/actionRouter.php';
        $page = Post::$redirection ?? Get::$path;
    } catch (Exception $e) {
        $page = '/register?error=' . $e->getMessage();
    } finally {
        header("Location: $page");
    }
}


$body = __DIR__ . '/view/' . $page . '.php';
if(!file_exists($body)) {
    $file = __DIR__ . '/view/404.php';
}

ob_start();

?>
<DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>My website</title>
    </head>
    <body>
        <header>

        </header>
        <?php include $body; ?>
        <footer>

        </footer>
    </body>
</html>
<?php

$HTML = ob_get_clean();

$config = [
    'indent'         => true,
    'output-xhtml'   => true,
    'wrap'           => 200
];

$tidy = new tidy();
$tidy->parseString($HTML, $config, 'utf8');
$tidy->cleanRepair();

echo $tidy;
?>