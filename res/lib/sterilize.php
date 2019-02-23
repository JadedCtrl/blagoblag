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
function auth_enforce($id, $permitted, $message="do that") {
	if (!user_logged_in()) {
		input_error("Sorry, you're not logged in!");
	}

	$class = user_class($id);
	if (!in_array($class, $permitted)) {
		perm_error("Mate, only a " . comma_sep($permitted, " or ")
			. " can " . $message . "-- you hecking "
			. $class . "!");
		return false;
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

	if (!empty($stack)) {
        	input_error("Some input is invalid: " . comma_sep($stack));
	}

	return true;
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

// STRING --> BOOLEAN
// Return whether or not a string is a tweet (<250 chars)
function is_tweet($string) {
	if (strlen($string) <= 250 && !empty($string)) {
		return true;
	} else {return false; }
}

// STRING --> BOOLEAN
// Return whether or not a string is a title (<50 chars)
function is_title($string) {
	if (strlen($string) <= 50 && !empty($string)) {
		return true;
	} else {return false; }
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

// NUMBER --> BOOLEAN
// Return whether or not a number is a post ID
function is_post_id($id) {
	if (post_title($id)) {
		return true;
	} else {
		return false;
	}
}

// NUMBER --> BOOLEAN
// Return whether or not a string is a post name
function is_post_title($title) {
	if (post_title_to_id($title)) {
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

// STRING --> BOOLEAN
// Return whether or not a given string is a valid (unused) post title 
function is_free_post_title($title) {
	if (!is_post_title($title) && is_ne_string($title)) {
		return true; } else { return false; }
}

// STRING --> BOOLEAN
// Return whether or not a given number is a valid (unused) psot ID
function is_free_post_id($id) {
	if (!is_post_id($id) && is_int($id)) {
		return true; } else { return false; }
}

// -------------------------------------

function bleep_word($word, $replacement) {
	$word = str_replace("a", $replacement, $word);
	$word = str_replace("e", $replacement, $word);
	$word = str_replace("i", $replacement, $word);
	$word = str_replace("o", $replacement, $word);
	$word = str_replace("u", $replacement, $word);
	$word = str_replace("y", $replacement, $word);

	return $word;
}

// STRING --> STRING
// you know how people'll write nasty stuff on bathroom stalls?
// this is like taking a sharpie and bleeping all that out
function profanity_sharpie($string) {
	$string = str_ireplace(" ass ", bleep_word(" ass ", "&#9829;"),
				$string);
	$string = str_ireplace(" asses ", bleep_word(" asses ", "&#9829;"),
				$string);
	$string = str_ireplace("fuck", bleep_word("fuck", "&#9829;"), $string);
	$string = str_ireplace("bitch", bleep_word("bitch", "&#9829;"),
				$string);
	$string = str_ireplace("dick", bleep_word("dick", "&#9829;"), $string);
	$string = str_ireplace("cunt", bleep_word("cunt", "&#9829;"), $string);

	$string = str_ireplace("shit", bleep_word("shit", "&#9734;"), $string);
	$string = str_ireplace("bitch", bleep_word("bitch", "&#9734;"),
				$string);

	$string = \ConsoleTVs\Profanity\Builder::blocker($string)->filter();

	return $string;
}
			

// -------------------------------------

// STRING --> STRING
// Agressively sanitize a string -- alias for rub_a_dub_dub()
function scrub($string) {
	return rub_a_dub_dub($string);
}

// STRING --> STRING
// don't forget your rubber duck <3
function rub_a_dub_dub($string) {
	$string = htmlentities($string, ENT_QUOTES, "UTF-8", false);
	$string = profanity_sharpie($string);
	return $string;
}	

// STRING --> STRING
// Agressively sanitize a string -- alias for rub_a_dub_dub()
function unscrub($string) {
	return html_entity_decode($string, ENT_QUOTES);
}


// -------------------------------------

function markdown($string) {
	$parsedown = new Parsedown();
	return $parsedown->text($string);
}

function markdown_inline($string) {
	$parsedown = new Parsedown();
	return $parsedown->line($string);
}

?>
