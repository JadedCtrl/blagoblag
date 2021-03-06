<?php
/* This file is free software: you can redistribute it and/or modify
   it under the terms of version 3 of the GNU Affero General Public
   License as published by the Free Software Foundation.

   This file is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU Affero General Public License for more details. */

$title = "Control Panel";
$depth = "../";
$mark  = "p_index";
include $depth . "res/lib/load.php";

// -------------------------------------

$id = $_GET['id'] ?? post_title_to_id($_GET['name']);
$name = post_title($id);

// -------------------------------------

if (empty($name)) {
	root_redirect("p/list/");
}

$local_exports = array('post_id' => $id,
		'post_title' => unscrub($name),
		'post_author' => post_author($id),
		'post_date' => post_date($id),
		'post_text' => markdown(post_text($id)));


// --------------------------------------

display_page($mark, $depth, $title, $local_exports);

?>
