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

$cur_id = user_logged_in();
$edit_id = $_GET['id'] ?? user_logged_in();

$full	= scrub($_POST['full_name']);
$bio	= scrub($_POST['bio']);
$email	= scrub($_POST['email']);
$url	= scrub($_POST['url']);
$class  = scrub($_POST['login']) ?? false;

// -------------------------------------

input_enforce(array($full, $bio, $email, $url),
		array("Full name", "Biography", "E-mail", "URL"),
		array("string", "string", "email", "url"));

// -------------------------------------

switch (1) {
	case (user_logged_in() == false):
		general_error("Guests can't edit accounts, nerd!");
		break;
	case ($cur_id != $edit_id):
		auth_enforce($cur_id, array("wizard", "archmage"), "edit other
				people's accounts");
		continue;
}

if ($class != false) {
	$auth = auth_enforce($cur_id, array("archmage"),
			"edit other people's classes");
	if ($auth != false) {
		user_set($edit_id, "class", $class);
	}
}

user_set($edit_id, "full_name", $full);
user_set($edit_id, "biography", $bio);
user_set($edit_id, "email", $email);
user_set($edit_id, "website", $url);

root_redirect($GLOBALS['user_prefix_id'] . $edit_id);

?>
