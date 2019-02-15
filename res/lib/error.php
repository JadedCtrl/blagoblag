<?php
/* This file is free software: you can redistribute it and/or modify
   it under the terms of version 3 of the GNU Affero General
   License as published by the Free Software Foundation.

   This file is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU Affero General Public License for more details. */


// STRING --> NIL
// Print out a general error, with $string as it's error-message.
function general_error($string) {
	echo $GLOBALS['twig']->render('error.twig.html',
					['error_message'=>$string]);
	exit;
}

// STRING --> NIL
// Print out an input error, with $string as it's error-message.
function input_error($string) {
	echo $GLOBALS['twig']->render('error.twig.html',
					['error_message'=>$string]);
	exit;
}

// STRING --> NIL
// Print out a general error, with $string as it's error-message.
function perm_error($string) {
	echo $GLOBALS['twig']->render('error.twig.html',
					['error_message'=>$string]);
	exit;
}

?>
