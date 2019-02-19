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

$auth_user = scrub($_POST['auth_user']);
$auth_pass = scrub($_POST['auth_pass']);
$auth_id   = user_name_to_id($auth_user);

$name	= scrub($_POST['name']);
$full	= scrub($_POST['full_name']);
$bio	= scrub($_POST['bio']);
$email	= scrub($_POST['email']);
$url	= scrub($_POST['url']);
$pass	= scrub($_POST['password']);
$login	= scrub($_POST['login']);

// -------------------------------------

auth_enforce($auth_id, $auth_pass,
	array("wizard", "archmage"), "make accounts");

input_enforce(array($name, $full, $bio, $email, $url, $pass,
			$login),
		array("Username", "Full name", "Biography", "E-mail",
		  	"URL", "Password", "Login class"),
		array("free_user_name", "string", "string",
			"email", "url", "ne_string",
		array("spectator", "wizard", "archmage", "contributor")));

// -------------------------------------

user_create($name, $pass, $login, $full, $email, $url, $bio);

root_redirect("user.php?name=" . $name);

?>
