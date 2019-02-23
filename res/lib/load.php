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
error_reporting(0);
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
include(root("res/lib/post.php"));
include(root("res/lib/blagoblag.php"));
include(root("res/lib/token.php"));

$loader= new Twig_Loader_Filesystem(root("res/themes/default/html"));
$twig = new Twig_Environment($loader, ['cache' =>
	root('cache/'), 'autoescape' => false]);

// -------------------------------------
// authentication

global $logged_id;
global $logged_in; $logged_in = false;

$test_id = user_logged_in();

$logged_id = $test_id ?? 0;
if ($logged_id != 0) {
	$logged_in = true;
}

// -------------------------------------
// global variable declaration
global $users; $users = user_ids();
global $user; $user = array();
global $posts; $posts = post_ids_recent();
global $post; $post = array();

$push_user_data = function($user_id) {
			$user_name = user_name($user_id);
			$GLOBALS['user'][$user_id] = user_data($user_id);
			$GLOBALS['user'][$user_name] = user_data($user_id);
		  };

$push_post_data = function($post_id) {
			$post_title = post_title($post_id);
			$GLOBALS['post'][$post_id] = post_data($post_id);
			$GLOBALS['post'][$post_title] = post_data($post_id);
		  };

array_map($push_user_data, $users);
array_map($push_post_data, $posts);

// -----------------

global $twig_exports;
$twig_exports = array('theme' => $GLOBALS['theme'],
			'users' => $GLOBALS['users'],
			'user' => $GLOBALS['user'],
			'posts' => $GLOBALS['posts'],
			'post' => $GLOBALS['post'],
			'user_prefix_id' => $GLOBALS['user_prefix_id'],
			'user_prefix_name' => $GLOBALS['user_prefix_name'],
			'post_prefix_id' => $GLOBALS['post_prefix_id'],
			'post_prefix_name' => $GLOBALS['post_prefix_name'],
			'instance_title' => $GLOBALS['instance_title'],
			'logged_id' => $GLOBALS['logged_id'],
			'logged_in' => $GLOBALS['logged_in']);

?>
