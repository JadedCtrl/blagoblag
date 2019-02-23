<?php
/* This file is free software: you can redistribute it and/or modify
   it under the terms of version 3 of the GNU Affero General Public
   License as published by the Free Software Foundation.

   This file is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU Affero General Public License for more details. */

$title = "Control Panel";
$depth = "../../";
$mark  = "u_edit_index";
include $depth . "res/lib/load.php";

// -------------------------------------

$cur_id = user_logged_in();
$edit_id = $_GET['id'] ?? $cur_id;

// -------------------------------------

$local_exports = array('user_id' => $edit_id,
		'user_full_name' => unscrub(user_full_name($edit_id)),
		'user_name' => user_name($edit_id),
		'user_bio' => unscrub(user_biography($edit_id)),
		'user_email' => user_email($edit_id),
		'user_website' => user_website($edit_id));


// --------------------------------------

switch (1) {
	case (user_logged_in() == false):
		general_error("You're not even logged in, fool! >;c");
		break;
	case ($cur_id != $edit_id):
		auth_enforce($cur_id, array("wizard", "archmage"), "edit other
			people's accounts");
		break;	
}

display_page($mark, $depth, $title, $local_exports);

?>
