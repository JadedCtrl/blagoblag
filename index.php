<?php
$depth = "";
include "res/lib/load.php";

echo $GLOBALS['twig']->render('index.twig.html', ['animal' => 'cat girl']);

?>
