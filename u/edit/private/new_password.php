<?php
/* This file is free software: you can redistribute it and/or modify
   it under the terms of version 3 of the GNU Affero General Public
   License as published by the Free Software Foundation.

   This file is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU Affero General Public License for more details. */

$depth = "../../../";
include $depth . "res/lib/load.php";

$id = user_logged_in();

$old_password = $_POST['password'];
$password = $_POST['new_password'];
$password_repeat = $_POST['new_password_repeat'];

// -------------------------------------

input_enforce(array($password),
		array("Password"),
		array("string"));

if ($password != $password_repeat) {
	general_error("Your passwords don't match.");
}

if (!user_valid_password($id, $old_password)) {
	general_error("Your old password was wrong.");
}

// -------------------------------------

$password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 11));

user_set($id, "hash", $password);

root_redirect("");

?>
