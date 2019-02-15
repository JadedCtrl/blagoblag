<?php
/* This file is free software: you can redistribute it and/or modify
   it under the terms of version 3 of the GNU Affero General Public
   License as published by the Free Software Foundation.

   This file is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU Affero General Public License for more details. */


// -------------------------------------

// NUMBER STRING --> VARYING
// Return the value of a given user's row
function user_get($id, $variable) {
	return db_get_cell("lusers", "id", $id, $variable);
}

// NUMBER STRING VARYING --> NIL
// Set the value of a given user's cell
function user_set($id, $variable, $new_value) {
	return db_set_cell("lusers", "id", $id, $variable, $new_value);
}

// -------------------------------------


// NUMBER STRING STRING [STRING STRING STRING STRING STRING] --> BOOLEAN
// Create a user of the given specification.
function user_create($id, $name, $password, $class="Spectator",
                        $full_name=NULL,  $email=NULL, $url=NULL, $bio=NULL) {

	return db_insert_row("lusers",
			array("id", "username", "hash", "class",
				"full_name", "email", "website", "biography"),
			array($id, $name, $password, $class,
				$full_name, $email, $url, $bio));
}

// NUMBER --> BOOLEAN
// Delete a user by their ID.
function user_delete($id) {
	return db_cmd("delete from lusers where id = " . $id);
}


// -------------------------------------


// NUMBER --> STRING
// Get a user's username from ID.
function user_id_to_name($id) {
	return user_get($id, "username");
}

// STRING --> NUMBER
// Get a user's ID from username. 
function user_name_to_id($username) {
	return db_get_cell("lusers", "username", string_wrap($username), "id");
}


// -------------------------------------


// NUMBER --> STRING
// Return a username from a user-ID
function user_name($id) {
	return user_id_to_name($id);
}

// NUMBER --> STRING
// Return a user's login-class from ID
function user_class($id) {
	return user_get($id, "class");
}

// NUMBER --> STRING
// Return a user's full name from ID
function user_full_name($id) {
	return user_get($id, "full_name");
}

// NUMBER --> STRING
// Return a user's email from ID
function user_email($id) {
	return user_get($id, "email");
}

// NUMBER --> STRING
// Return a user's website URL from ID
function user_website($id) {
	return user_get($id, "website");
}

// NUMBER --> STRING
// Return a user's biography from ID
function user_biography($id) {
	return user_get($id, "biography");
}

// -------------------------------------


// NUMBER --> ARRAY
// Fetch an array of a user's IDs
function user_ids() {
	return db_get_columns("lusers", "id");
}


// -------------------------------------


// NUMBER --> ARRAY
// Fetch an array of a user's posts (by ID)
function user_posts($id) {
	return db_get_cell("posts", "user", $id, "id");
}


// -------------------------------------


// NUMBER --> ARRAY
// Return an array filled with all of a user's relevant data.
function user_data($id) {
	return array('full_name' => user_full_name($id),
			'name' => user_name($id),
			'bio' => user_biography($id),
			'email' => user_email($id),
			'website' => user_website($id),
			'posts' => user_posts($id));
}
			

// -------------------------------------


// NUMBER STRING --> BOOLEAN
// Return whether or not a given password is valid.
function user_valid_password($id, $password) {
	return password_verify($password, user_get($id, "hash"));
}

?>
