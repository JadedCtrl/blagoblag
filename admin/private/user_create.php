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
$name = $_POST['name'];
$full_name = $_POST['full_name'];
$bio = $_POST['bio'];
$email = $_POST['email'];
$url = $_POST['url'];
$password = $_POST['password'];
$login = $_POST['login'];
$password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 11));

// -------------------------------------

auth_enforce($auth_user_id, $auth_pass,
	array("wizard", "archmage"), "make accounts");

$invalid = input_enforce(array($id, $name, $full_name, $bio, $email, $url,
			$password, $login),
		  array("ID", "Username", "Full name", "Biography", "E-mail",
		  	"URL", "Password", "Login class"),
		  array("free_user_id", "free_user_name", "string", "string",
		  	"email", "url", "ne_string",
			array("spectator", "wizard", "archmage",
				"contributor")));

if (!empty($invalid)) {
	input_error("Some input is invalid: " . comma_sep($invalid));
}

// -------------------------------------

user_create($id, $name, $password, $login,
		$full_name,  $email, $url, $bio);

root_redirect("user.php?name=" . $name);

?>
