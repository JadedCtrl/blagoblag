<?php
/* This file is free software: you can redistribute it and/or modify
   it under the terms of version 3 of the GNU Affero General Public
   License as published by the Free Software Foundation.

   This file is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU Affero General Public License for more details. */


function user_token_generate($id) {
	return crypt($id . rand(0, 5000000));
}

// NUMBER --> NUMBER
// Generate a new login-token and associate it with the user's account.
// Returns the token number.
function user_token_set($id, $token) {
	setcookie("token", $token, time() + 60*60*24*30, "/");
	setcookie("id", $id, time() + 60*60*24*30, "/");
	echo "token" . $token;
	db_set_cell("lusers", "id", $id, "token", $token);
	return $token;
}

// NUMBER NUMBER --> BOOLEAN
// Return whether or not a token is valid for a certain user account
function user_token_validate($id, $token) {
	$valid_token = db_get_cell("lusers", "id", $id, "token");

	if (html_entity_decode($token) == $valid_token) {
		return true;

	} else {
		return false;
	}

}


// -------------------------------------


// NUMBER --> NIL
// Log a user in
function user_log_in($id) {
	$token = user_token_generate($id);
	user_token_set($id, $token);

	return true;
}

// NUMBER --> NIL
// Log out a user, by burning the DB-token, and eating the log-in cookies
function user_log_out($id) {
	user_token_set($id, "escapee");
	setcookie("token", "escapee", time(), "/");
	setcookie("id", "death, the destroyer", time(), "/");

	return true;
}

// -------------------------------------

// NIL --> NUMBER/BOOLEAN
// Return whether or not a user is logged in-- if yes, return user ID
function user_logged_in() {
	$id = $_COOKIE['id'] ?? 1;
	$token = $_COOKIE['token'] ?? 1;

	if (user_token_validate($id, $token)) {
		return $id;
	} else {
		return false;
	}
}

// -------------------------------------

// NUMBER STRING --> BOOLEAN
// Return whether or not a given password is valid.
function user_valid_password($id, $password) {
	if (password_verify($password, user_get($id, "hash"))) {
		return true;
	} else {
		return false;
	}
}

?>
