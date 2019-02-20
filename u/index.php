<?php
/* This file is free software: you can redistribute it and/or modify
   it under the terms of version 3 of the GNU Affero General Public
   License as published by the Free Software Foundation.

   This file is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU Affero General Public License for more details. */


$depth = "../";
$mark  = "u_index";
$title = "Death";
include "../res/lib/load.php";

// -------------------------------------

$id = $_GET['id'] ?? user_name_to_id($_GET['name']);
$name = user_name($id);

// -------------------------------------

if (empty($_GET['id']) && empty($_GET['name'])) {
	root_redirect('u/list/');
} else if (!is_user_id($id) && empty($name)) {
	general_error("It looks like that isn't a real user.");
}

// -------------------------------------

global $user_posts; $user_posts = user_posts($id);
global $user_post; $user_post = array();

// this is used to make associative array for a user's posts, based on
// both post ID and post title
$push_post_data = function($post_id) {
			$title = post_title($post_id);
			$GLOBALS['user_post'][$post_id] = post_data($post_id);
			$GLOBALS['user_post'][$title]   = post_data($post_id);
		};

array_map($push_post_data, $user_posts);

// -----------------

$local_exports = array('user_id' => $id,
			'user_full_name' => unscrub(user_full_name($id)),
			'user_name' => $name,
			'usr_bio' => unscrub(user_biography($id)),
			'user_email' => user_email($id),
			'user_website' => user_website($id),
			'user_posts' => $user_posts,
			'user_post' => $user_post);

// -------------------------------------

display_page($mark, $depth, $title, $local_exports);

?>
