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
$mark  = "u_old_index";
include "../../res/lib/load.php";

// --------------------------------------

switch (1) {
	case (user_logged_in() != false):
		general_error("You've already done that, you know. Log in, I
				mean. You OK there, friend?");
		break;
	default:	
		display_page($mark, $depth, $title);
}


?>
