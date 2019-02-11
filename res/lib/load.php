<?php

// PATH --> PATH
// Take a path from root and turn it into a relative path.
function root($path) {
	return $GLOBALS['depth'] . $path;
}

// -------------------------------------

require_once root("vendor/autoload.php");

$loader= new Twig_Loader_Filesystem(root("res/themes/default/html"));
$twig = new Twig_Environment($loader, ['cache' =>
	root('cache/')]);

?>
