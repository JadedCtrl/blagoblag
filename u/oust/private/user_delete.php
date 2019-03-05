<?php
/* This file is free software: you can redistribute it and/or modify
   it under the terms of version 3 of the GNU Affero General Public
   License as published by the Free Software Foundation.

   This file is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU Affero General Public License for more details. */

$depth = "../../../";
include "../../../res/lib/load.php";

$id = scrub($_GET['id']);

// -------------------------------------

if (user_logged_in() != $id) {
	auth_enforce(user_logged_in(),
			array("wizard", "archmage"), "obliterate users");
}

input_enforce(array($id),
		array("id"),
		array("user_id"));

// -------------------------------------

user_delete($id);

root_redirect("u/list");

?>
