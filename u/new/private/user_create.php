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

$name	= scrub($_POST['name']);
$full	= scrub($_POST['full_name']);
$bio	= scrub($_POST['bio']);
$email	= scrub($_POST['email']);
$url	= scrub($_POST['url']);
$pass	= scrub($_POST['password']);

// -------------------------------------

if ($GLOBALS['registration'] != true) {
	general_error("Sorry, registration's disabled on this server!");
}

input_enforce(array($name, $full, $bio, $email, $url, $pass),
		array("Username", "Full name", "Biography", "E-mail",
		  	"URL", "Password"),
		array("free_user_name", "string", "string",
			"email", "url", "ne_string"));

// -------------------------------------

user_create($name, $pass, "contributor", $full, $email, $url, $bio);

root_redirect("u/index.php?name=" . $name);

?>
