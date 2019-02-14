<?php
/* This file is free software: you can redistribute it and/or modify
   it under the terms of version 3 of the GNU Affero General Public                     License as published by the Free Software Foundation.

   This file is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU Affero General Public License for more details. */


// -------------------------------------
// connection setup
// create the dsn from values in /config.php
$dsn =	$GLOBALS['db_type'] . ":"
	. $GLOBALS['db_host']
	. $GLOBALS['db_port']
	. $GLOBALS['db_socket']
	. $GLOBALS['db_name']
	. "charset=utf8mb4";


$pdo = (new PDO($dsn,	$GLOBALS['db_user'], $GLOBALS['db_pass'],
			$GLOBALS['db_args']));


// -------------------------------------
// table setup
// create needed tables, if nonexistant
if (!db_table_existant("lusers")) {
	db_create_table("lusers",
		array("id int primary key","username varchar(20)",
		"biography longtext","email varchar(50)","website varchar(50)",
		"password_hash varchar(80)","full_name varchar(50)",
		"login varchar(20)")); }

if (!db_table_existant("posts")) {
	db_create_table("posts",
		array("id int primary key","title varchar(200)","date datetime",
		"user int","text longtext")); }

if (!db_table_existant("comments")) {
	db_create_table("comments",
		array("id int primary key","displayname varchar(20)",
		"user int","text longtext", "date datetime")); }



// -------------------------------------

// STRING --> ARRAY
// Execute a DB command
function db_cmd($query) {
	$stmt = $GLOBALS['pdo']->query($query);
	if (is_bool($stmt)) {
		return $stmt;
	} else {
		return $stmt->fetch();
	}
}

// -------------------------------------

// STRING STRING --> ARRAY
// Return all values of a specific column
function db_get_columns($table, $column) {
	return db_cmd("select " . $column . " from " . $table);
}	

// STRING STRING VARYING --> ARRAY
// Return all rows that have an 'identifier' column set to given value
function db_get_rows($table, $identifier, $value) {
	return db_cmd("select * from " . $table . " where " . $identifier .
	" = " . $value . ";");
}

// STRING STRING VARYING STRING --> ARRAY
// Return the value of a specific column in a given row, identified by an
// 'identifier' column set to the given value
function db_get_cell($table, $identifier, $value, $cell) {
	return db_get_rows($table, $identifier, $value)[$cell];
}

// --------------------------------------

// STRING STRING VARYING STRING VARYING --> NIL
// Edit the value of a cell
function db_set_cell($table, $identifier, $value, $cell, $new_value) {
	if (is_string($value)) { $value = "'" . $value . "'"; }
	if (is_string($new_value)) { $new_value = "'" . $new_value . "'"; }

	return db_cmd("update " . $table 
			. " set " . $cell . " = " . $new_value
			. " where " . $identifier . " = " . $value) . ";";
}

// -------------------------------------

// STRING ARRAY ARRAY --> BOOLEAN
// Create a table with given values to given columns.
// First array is a list of columns (as would be provided to SQL), and the
// second is the list of values (as would follow " values " in SQL)
function db_insert_row($table, $variables, $values) {
	$variables = comma_sep($variables);
	$values = comma_sep(strings_wrap($values));


	return db_cmd("insert into " . $table
			. " (".  $variables .")"
			. " values ("
			. $values . ")" . ";");
}

// -------------------------------------

// STRING --> BOOLEAN
// Return whether or not a table of given name exists
function db_table_existant($table) {
	if (!db_cmd("select * from information_schema.tables "
		   . " where table_name = " . string_wrap($table) . ";")) {
		return false;
	} else {
		return true;
	}
}

// STRING ARRAY --> BOOLEAN
// Create a table of given name and columns (with array of column-strings)
function db_create_table($table, $columns) {
	return db_cmd("create table " . $table
			. " (" . comma_sep($columns) . ");");
}

?>
