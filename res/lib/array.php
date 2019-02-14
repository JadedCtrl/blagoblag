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
function comma_sep($array) {
	global $stack;
	$stack = "";

	$comma_print = function($item) {
		$GLOBALS['stack'] = $GLOBALS['stack']
					. ", " . $item;
	};

	array_map($comma_print, $array);

	$stack = preg_replace('/^, /', '', $stack);

	return $stack;
}

?>
