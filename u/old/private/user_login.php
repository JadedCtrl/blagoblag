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

$user	= scrub($_POST['name']);
$pass	= scrub($_POST['password']);

// -------------------------------------

input_enforce(array($user, $pass),
		array("Username", "Password"),
		array("user_name", "string"));

// -------------------------------------

if (user_valid_password(user_name_to_id($user), $pass)) {
	user_log_in(user_name_to_id($user));
}

root_redirect("u/index.php?name=" . $user);

?>
