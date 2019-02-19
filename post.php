<?php
/* This file is free software: you can redistribute it and/or modify
   it under the terms of version 3 of the GNU Affero General Public
   License as published by the Free Software Foundation.

   This file is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU Affero General Public License for more details. */

$depth = "";
$title = "";
$mark  = "post";
include "res/lib/load.php";

// -------------------------------------

$id = $_GET['id'] ?? post_name_to_id($_GET['name']);
$name = post_title($id);

// --------------------------------------

$text = markdown(post_text($id));
$date = post_date($id);
$data = post_data($id);

$user_id = post_author($id);
$username = user_name($user_id);
$full_name = user_full_name($user_id);

$local_exports = array('id' => $id, 'text' => $text, 'username' => $username,
			'user_id' => $user_id, 'full_name' => $full_name,
			'data' => $data, 'title' => $name,
			'date' => $date);

// -------------------------------------

display_page($mark, $depth, $title, $local_exports);

?>
