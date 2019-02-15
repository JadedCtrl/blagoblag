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
include(root("res/lib/error.php"));
include(root("res/lib/sterilize.php"));
include(root("res/lib/db.php"));
include(root("res/lib/url.php"));
include(root("res/lib/blagoblag.php"));

$loader= new Twig_Loader_Filesystem(root("res/themes/default/html"));
$twig = new Twig_Environment($loader, ['cache' =>
	root('cache/')]);



// -------------------------------------
// global variable declaration
global $users; $users = user_ids();
global $user; $user = array();

$push_user_data = function($user_id) {
			$user_name = user_name($user_id);
			$GLOBALS['user'][$user_id] = user_data($user_id);
			$GLOBALS['user'][$user_name] = user_data($user_id);
		  };

array_map($push_user_data, $users);

// global $posts; $posts = post_ids();
// global $post; $post = array();
// $post = array_map(post_data, $posts);

// -----------------

global $twig_exports;
$twig_exports = array('theme' => $GLOBALS['theme'],
			'users' => $GLOBALS['users'],
			'user' => $GLOBALS['user']);
			//'posts' => $GLOBALS['posts'],
			//'post' => $GLOBALS['post']);

?>
