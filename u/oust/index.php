<?php
/* This file is free software: you can redistribute it and/or modify
   it under the terms of version 3 of the GNU Affero General Public
   License as published by the Free Software Foundation.

   This file is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU Affero General Public License for more details. */

$title = "Delete User";
$mark = "u_oust_index";
$depth = "../../";
include "../../res/lib/load.php";

$id = scrub($_GET['id']);

// --------------------------------------

if (user_logged_in() != $id) {
	auth_enforce(user_logged_in(),
			array("wizard", "archmage"), "obliterate people");
}

input_enforce(array($id),
		array("id"),
		array("user_id"));

// -------------------------------------

display_page($mark, $depth, $title, array('user_id' => $id));

?>
