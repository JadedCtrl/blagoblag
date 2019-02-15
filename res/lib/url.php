<?php
/* This file is free software: you can redistribute it and/or modify
   it under the terms of version 3 of the GNU Affero General Public
   License as published by the Free Software Foundation.

   This file is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU Affero General Public License for more details. */


// STRING -- > STRING
// Turn a path (relative to root) into absolute URL
function root_url($string) {
	return protocol() . "://" . $_SERVER['HTTP_HOST'] . "/"
		. $GLOBALS['root']
		. $string;
}


// NIL --> STRING
// Return the current protocol (HTTP, HTTPS, etc)
function protocol() {
	return explode('/', $_SERVER['SERVER_PROTOCOL'])[0];
}


// STRING --> NIL
// Redirect to a regular URL (I.E., "https://duckduckgo.com")
function redirect($url) {
	header('Location: ' . $url);
	return;
}

// STRING --> NIL
// Redirect to a URL relative to root (I.E., "res/img/")
function root_redirect($path) {
	header('Location: ' . root_url($path));
	return;
}
