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

$id = $_POST['id'];
$name = $_POST['name'];
$full_name = $_POST['full_name'];
$bio = $_POST['bio'];
$email = $_POST['email'];
$url = $_POST['url'];
$password = $_POST['password'];
$login = $_POST['login'];

$invalid = input_enforce(array($id, $name, $full_name, $bio, $email, $url,
			$password, $login),
		  array("ID", "username", "full name", "biography", "email",
		  	"url", "password", "login"),
		  array("int", "string", "string", "string", "email",
		  	"url", "password",
				array("contributor", "spectator", "wizard",
					"admin")));

if (!is_bool($invalid)) {
	input_error("Some input is invalid: " . $invalid);
}

$result = user_create($id, $name, $password, $login,
			$full_name,  $email, $url, $bio);
if ($result) {
	header('Location: http://localhost/blagoblag/user.php?id=' . $id);
} else {
	general_error("<em>Something</em> went wrong.");
}

?>
