<?php
/* This file is free software: you can redistribute it and/or modify
   it under the terms of version 3 of the GNU Affero General Public
   License as published by the Free Software Foundation.

   This file is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU Affero General Public License for more details. */


// VARYING --> STRING
// If a given variable is a string, wrap it with apostrophes.
// Otherwise, just return it as given.
function string_wrap($value) {
	if (is_string($value)) {
		return "'" . $value . "'";
	} else {
		return $value;
	}
}

// ARRAY --> ARRAY
// 'Wrap' all strings in array with apostrophes.
function strings_wrap($array) {
	return array_map("string_wrap", $array);
}
?>
