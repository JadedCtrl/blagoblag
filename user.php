<?php
/* This file is free software: you can redistribute it and/or modify
   it under the terms of version 3 of the GNU Affero General Public
   License as published by the Free Software Foundation.

   This file is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU Affero General Public License for more details. */


$depth = "";
include "res/lib/load.php";

// -------------------------------------

$id = $_GET['id'] ?? user_name_to_id($_GET['name']);
$name = user_name($id);

// -------------------------------------

if (!is_user_id($id)) {
	general_error("It looks like that isn't a real user.");
}
if (empty($name)) {
	general_error("It looks like that isn't a real user...");
}

// ------------------------------------

$local_exports = array('full_name' => user_full_name($id), 'name' => $name,
			'bio' => user_biography($id), 'email' =>
			user_email($id), 'website' => user_website($id));

// -------------------------------------

display_page("user.twig.html", $depth, $title, $local_exports);

?>
