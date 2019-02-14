<?php
/* This file is free software: you can redistribute it and/or modify
   it under the terms of version 3 of the GNU Affero General 
   License as published by the Free Software Foundation.

   This file is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU Affero General Public License for more details. */


// PATH --> PATH
// Take a path from root and turn it into a relative path.
function root($path) {
	return $GLOBALS['depth'] . $path;
}

// -------------------------------------

include(root("config.php"));
require_once root("vendor/autoload.php");

include(root("res/lib/string.php"));
include(root("res/lib/array.php"));
include(root("res/lib/user.php"));
include(root("res/lib/post.php"));
include(root("res/lib/comment.php"));
include(root("res/lib/db.php"));

$loader= new Twig_Loader_Filesystem(root("res/themes/default/html"));
$twig = new Twig_Environment($loader, ['cache' =>
	root('cache/')]);

?>
