<?php
/* This file is free software: you can redistribute it and/or modify
   it under the terms of version 3 of the GNU Affero General Public
   License as published by the Free Software Foundation.

   This file is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU Affero General Public License for more details. */

$depth = "../../";
include "../../res/lib/load.php";

$auth_user = $_POST['auth_user'];
$auth_pass = $_POST['auth_pass'];
$auth_user_id = user_name_to_id($auth_user);

$id = intval($_POST['id']);

// -------------------------------------

auth_enforce($auth_user_id, $auth_pass,
	array("wizard", "archmage"), "destroy users");

$invalid = input_enforce(array($id), array("ID"), array("user_id"));

if (!empty($invalid)) {
	input_error("Some input is invalid: " . comma_sep($invalid));
}

// -------------------------------------

user_delete($id);

root_redirect("user.php?name=" . $name);

?>
