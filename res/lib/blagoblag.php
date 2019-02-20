<?php
/* This file is free software: you can redistribute it and/or modify
   it under the terms of version 3 of the GNU Affero General Public
   License as published by the Free Software Foundation.

   This file is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU Affero General Public License for more details. */


// STRING STRING STRING [ARRAY] --> BOOLEAN
// Render and display a page, based on it's template-path, title, relative
// depth, and an optional array of more Twig variable exports.
function display_page($mark, $depth, $title, $local_exports=array()) {
	echo $GLOBALS['twig']->render("head.twig.html",
				make_exports($depth, $title, $mark,
						$local_exports));
	echo $GLOBALS['twig']->render("navbar.twig.html",
				make_exports($depth, $title, $mark,
						$local_exports));
	echo $GLOBALS['twig']->render($mark . ".twig.html",
				make_exports($depth, $title, $mark,
						$local_exports));
	echo $GLOBALS['twig']->render("foot.twig.html",
				make_exports($depth, $title, $mark,
						$local_exports));
	return true;	
}
