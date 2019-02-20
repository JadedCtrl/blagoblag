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
function post_get($id, $variable) {
	return db_get_cell("posts", "id", $id, $variable);
}

// NUMBER STRING VARYING --> NIL
// Set the value of a given user's cell
function post_set($id, $variable, $new_value) {
	return db_set_cell("posts", "id", $id, $variable, $new_value);
}

// -------------------------------------


// NUMBER STRING STRING [STRING STRING STRING STRING STRING] --> BOOLEAN
// Create a user of the given specification.
function post_create($title, $author, $desc, $text) {
	$id = db_new_id("posts", "id");

	return db_insert_row("posts",
			array("id", "user", "description", "date",
				"text", "title"),
			array($id, $author, $desc, 
				date("Y-m-d H:i:s"), $text, $title));
}

// NUMBER --> BOOLEAN
// Delete a user by their ID.
function post_delete($id) {
	return db_cmd("delete from posts where id = " . $id);
}


// -------------------------------------

function post_title_to_id($name) {
	return db_get_cell("posts", "title", string_wrap($name), "id");
}

// NUMBER --> STRING
// Return a post's title from ID
function post_title($id) {
	return post_get($id, "title");
}

// NUMBER --> STRING
// Return a post's description from ID
function post_description($id) {
	return post_get($id, "description");
}

// NUMBER --> STRING
// Return a post's date from ID
function post_date($id) {
	return post_get($id, "date");
}


// NUMBER --> STRING
// Return the author's user ID from post ID
function post_author($id) {
	return post_get($id, "user");
}

// NUMBER --> STRING
// Return the post's text from post ID
function post_text($id) {
	return post_get($id, "text");
}


// -------------------------------------


// NUMBER --> ARRAY
// Fetch an array of a post's IDs
function post_ids() {
	return db_get_columns("posts", "id", "desc", "date");
}


// -------------------------------------


// NUMBER --> ARRAY
// Fetch an array of a post's IDs
function post_ids_recent() {
	return db_get_columns("posts", "id", "desc", "date", 25);
}


// -------------------------------------



// NUMBER --> ARRAY
// Return an array filled with all of a user's relevant data.
function post_data($id) {
	return array('title' => post_title($id),
			'date' => post_date($id),
			'author' => post_author($id),
			'text' => post_text($id),
			'desc' => post_description($id));
}


?>
