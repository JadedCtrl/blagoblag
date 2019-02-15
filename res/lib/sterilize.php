<?php
/* This file is free software: you can redistribute it and/or modify
   it under the terms of version 3 of the GNU Affero General Public
   License as published by the Free Software Foundation.

   This file is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU Affero General Public License for more details. */


// NUMBER STRING ARRAY [STRING] --> NIL
// Make sure a user is both authenticated *and* permitted to do a given task,
// aka in the right login-class.
function auth_enforce($id, $password, $permitted, $message="do that") {
	if (!user_valid_password($id, $password)) {
		input_error("Sorry, your user-name or password is wrong.");
	}

	$class = user_class($id);
	if (!in_array($class, $permitted)) {
		perm_error("Mate, only a " . comma_sep($permitted, " or ")
			. " can " . $message . "-- you hecking "
			. $class . "!");
	}
}

// ARRAY ARRAY ARRAY --> ARRAY
// Validate a list of values against a corresponding list of types;
// return a list of names (corresponding to the values) that don't
// match their types. If an empty array is returned, then, all inputs are
// valid.
// Two non-existant "pseudo-types" are accepted-- "url" and "e-mail".
// A "type" can also be an array of acceptable values.
// Example:
//	input_enforce(["apple", 4, "ap@ap.co.uk", "never"],
//			["Fruit", "Age", "E-mail", "Preference"],
//			["string", "int", "email",
//						["never", "always", "now"]]);
//
// ... it's an ugly, long function, I know...
function input_enforce($values, $names, $types) {
	$stack = array();
	$i = 0;

	while ($i < count($values)) {
		$value = $values[$i];
		$type = $types[$i];
		$name = $names[$i];
		$res = true;
		
		switch ($type) {
			case (is_array($type)):
				if (!in_array($value, $type)) { $res = false; }
				break;
			
			default:
				$type_check = "is_" . $type;
				if (!call_user_func($type_check, $value)) {
					$res = false;
				}
				break;
		}

		if (!$res) {
			$stack[] = $name;
		}

		$i++;
	}


	return $stack;
}


// -------------------------------------
// pseudo-types

// STRING --> BOOLEAN
// Return whether or not a given string is a valid e-mail.
function is_email($string) {
	return filter_var($string, FILTER_VALIDATE_EMAIL);
}

// STRING --> BOOLEAN
// Return whether or not a given string is a valid url.
function is_url($string) {
	return filter_var($string, FILTER_VALIDATE_URL);
}

// VARYING --> BOOLEAN
// Return whether or not a given value is a non-empty string
function is_ne_string($value) {
	if (is_string($value) && !empty($value)) {
		return true;
	} else {
		return false;
	}
}

// -------------------------------------

// STRING --> BOOLEAN
// Return whether or not a string is already a username
function is_user_name($username) {
	if (user_name_to_id($username)) {
		return true;
	} else {
		return false;
	}
}

// NUMBER --> BOOLEAN
// Return whether or not a number is already a user ID
function is_user_id($id) {
	if (in_array($id, $GLOBALS['users'])) {
		return true;
	} else {
		return false;
	}
}

// -------------------------------------

// STRING --> BOOLEAN
// Return whether or not a given string is a valid (unused) username
function is_free_user_name($username) {
	if (!is_user_name($username) && is_ne_string($username)) {
		return true; } else { return false; }
}

// STRING --> BOOLEAN
// Return whether or not a given number is a valid (unused) user ID
function is_free_user_id($id) {
	if (!is_user_id($id) && is_int($id)) {
		return true; } else { return false; }
}


// -------------------------------------


?>
