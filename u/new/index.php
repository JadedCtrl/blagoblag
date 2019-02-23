<?php
/* This file is free software: you can redistribute it and/or modify
   it under the terms of version 3 of the GNU Affero General Public
   License as published by the Free Software Foundation.

   This file is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU Affero General Public License for more details. */

$title = "Control Panel";
$depth = "../../";
$mark  = "u_new_index";
include "../../res/lib/load.php";

// --------------------------------------

switch (1) {
	case (user_logged_in() != false):
		general_error("You can't make an account… while using another
				account. LOL");
		break;
	case ($GLOBALS['registration'] == true):
		display_page($mark, $depth, $title);
		break;
	default:
		general_error("Sorry, registration's disabled on this server!");
		break;
}

?>
