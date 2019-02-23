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

$user	= $_POST['name'];
$pass	= $_POST['password'];

// -------------------------------------

$user_id = user_name_to_id($user);
input_enforce(array($user, $pass),
		array("Username", "Password"),
		array("user_name", "string"));

// -------------------------------------

switch (1) {
	case (user_logged_in() != false):
		general_error("You've already done that, you know. Log in, I
				mean. You OK there, friend?");
		break;
	default:
		if (user_valid_password($user_id, $pass)) {
			user_log_in($user_id);
			root_redirect($GLOBALS['user_prefix_id'] . $user_id);
		} else {
			general_error("Sorry, it looks like you have the
					wrong username or password!");
		}
		break;
}

?>
