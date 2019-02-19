<?php
/* This file is free software: you can redistribute it and/or modify
   it under the terms of version 3 of the GNU Affero General Public
   License as published by the Free Software Foundation.

   This file is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU Affero General Public License for more details. */


// ARRAY -- > STRING
// Turn a 1D array into a comma-seperated string
function comma_sep($array, $seperator=", ") {
	global $string;
	$string = $seperator;
	global $stack;
	$stack = "";

	$comma_print = function($item) {
		$GLOBALS['stack'] = $GLOBALS['stack']
					. $GLOBALS['string'] . $item;
	};

	array_map($comma_print, $array);

	$stack = preg_replace('/^' . $string . '/', '', $stack);

	return $stack;
}


// STRING STRING [ARRAY] --> ARRAY
// Return exports for Twig-- with the required global & local exports,
// along with any optional local ones.
function make_exports($depth, $title, $mark, $local = array()) {
	$exports = $GLOBALS['twig_exports'];

	$exports['mark']  = $mark;
	$exports['depth'] = $depth;
	$exports['title'] = $title;

	return array_merge($exports, $local);
}

?>
