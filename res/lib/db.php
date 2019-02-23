<?php
/* This file is free software: you can redistribute it and/or modify
   it under the terms of version 3 of the GNU Affero General Public
   License as published by the Free Software Foundation.
   This file is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU Affero General Public License for more details. */

/* note: should really make variable-naming more SQL-adherent and consistent
 *       also rethink a lot fo these abstractions
 *       also use prepared statements (as in http://bobby-tables.com/php) */

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
		"hash char(60)","full_name varchar(50)",
		"class varchar(20)")); 

	user_create("root", "password", "archmage", "Sorĉistino Root",
			"jadedctrl@teknik.io",
			"https://git.eunichx.us/blagoblag.git",
			"Use my account (password is `password`) to create your
			own archmage account-- then DELETE ME. I am a security
			risk that should be destroyed ASAP.");
}

if (!db_table_existant("posts")) {
	db_create_table("posts",
		array("id int primary key","title varchar(50)","date datetime",
		"description varchar(250)", "user int","text longtext")); }

if (!db_table_existant("comments")) {
	db_create_table("comments",
		array("id int primary key","displayname varchar(20)",
		"user int","text longtext", "date datetime")); }



// -------------------------------------

// STRING --> ARRAY
// Execute a DB command
function db_cmd($query) {
	$stmt = $GLOBALS['pdo']->query($query);
	$stack = array();

	if (is_bool($stmt)) {
		return $stmt;
	} else {
		return $stmt->fetchAll();
	}
}

// -------------------------------------

// STRING STRING --> ARRAY
// Return all values of a specific column
function db_get_columns($table, $column,
			$order = null, $ordered = null, $max = null) {

	$command = "select " . $column . " from " . $table;

	if (is_string($ordered)) {
		$command = $command . " order by " . $ordered . " " . $order;
	} else {
		$command = $command . " order by " . $column . " " .  $order;
	}

	if (is_int($max)) {
		$command = $command . " limit 0," . $max;
	}

	$command = $command . ";";

	// -----------------	

	$result = db_cmd($command);

	$result_nest = function($array) {
				return $array[0];
			};

	if (is_array($result)) {
		return array_map($result_nest, $result);
	} else {
		return $result;
	}
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
	$results = db_get_rows($table, $identifier, $value);

	if (count($results) > 0) {
		return $results[0][$cell];
	} else {
		return false;
	}
}

// !!!
// !!! ['id'] is used instead of $cell !!!
// STRING STRING VARYING STRING --> ARRAY
// Return the value of a specific column in a given row, identified by an
// 'identifier' column set to the given value
function db_get_cells($table, $identifier, $value, $cell) {
	$id_pop = function ($row, $cell) {
			return $row['id'];
		};

	$rows = db_get_rows($table, $identifier, $value);

	return array_map($id_pop, $rows, $cell);
}

// --------------------------------------

// STRING STRING VARYING STRING VARYING --> NIL
// Edit the value of a cell
function db_set_cell($table, $identifier, $value, $cell, $new_value) {
	if (is_string($value)) { $value = "'" . $value . "'"; }
	if (is_string($new_value)) { $new_value = "'" . $new_value . "'"; }

	return db_cmd("update " . $table 
			. " set " . $cell . " = " . $new_value
			. " where " . $identifier . " = " . $value . ";");
}

// -------------------------------------

// STRING STRING --> VARYING
// Return the 'biggest' value in a column, as dictated by 'desc' ordering
function db_get_biggest($table, $column) {
	return db_get_columns($table, $column, "desc")[0];
}

// STRING STRING --> VARYING
// Return the 'smallest' value in a column, as dictated by 'asc' ordering
function db_get_smallest($table, $column) {
	return db_get_columns($table, $column, "asc")[0];
}

// -------------------------------------

// STRING STRING --> INTEGER
// When passed a column of numbers, it'll increment the biggest number. Good
// for creating IDs. If there aren't any numbers in the column, it'll choose 1.
function db_new_id($table, $column) {
	$biggest = db_get_biggest($table, $column);

	if (is_nan($biggest)) {
		return 1;
	} else {
		return $biggest + 1;
	}
}

// -------------------------------------

// STRING ARRAY ARRAY --> BOOLEAN
// Create a table with given values to given columns.
// First array is a list of columns (as would be provided to SQL), and the
// second is the list of values (as would follow " values " in SQL)
function db_insert_row($table, $variables, $values) {
	$variables = comma_sep($variables, ", ");
	$values = comma_sep(strings_wrap($values), ", ");

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
