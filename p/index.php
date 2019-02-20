<?php
/* This file is free software: you can redistribute it and/or modify
   it under the terms of version 3 of the GNU Affero General Public
   License as published by the Free Software Foundation.

   This file is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU Affero General Public License for more details. */

$depth = "../";
$title = "";
$mark  = "p_index";
include "../res/lib/load.php";

// -------------------------------------


$id = $_GET['id'] ?? post_title_to_id($_GET['name']);
$name = post_title($id);

// -------------------------------------

if (empty($_GET['id']) && empty($_GET['name'])) {
	root_redirect('p/list/');
} else if (!is_post_id($_GET['id']) && !is_post_title($_GET['name'])) {
	general_error("We can't find that post! :(");
}

// --------------------------------------

$post_text = markdown(post_text($id));
$post_date = post_date($id);
$post_data = post_data($id);

$user_id = post_author($id);
$username = user_name($user_id);
$full_name = user_full_name($user_id);

$local_exports = array('post_id' => $id, 'post_text' => $post_text, 
			'post_author' => $user_id,
			'post_data' => $post_data, 'post_title' => $name,
			'post_date' => $date);

// -------------------------------------

display_page($mark, $depth, $title, $local_exports);

?>
