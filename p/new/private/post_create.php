<?php
/* This file is free software: you can redistribute it and/or modify
   it under the terms of version 3 of the GNU Affero General Public
   License as published by the Free Software Foundation.

   This file is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU Affero General Public License for more details. */

$depth = "../../../";
include "../../../res/lib/load.php";

$title = scrub($_POST['title']);
$desc = scrub($_POST['desc']);
$text = scrub($_POST['text']);

// -------------------------------------

auth_enforce(user_logged_in(),
		array("contributor", "wizard", "archmage"), "make posts");

input_enforce(array($title, $desc, $text),
		array("Title", "Summary", "Text"),
		array("title", "tweet", "ne_string"));

// -------------------------------------

post_create($title, user_logged_in(), $desc, $text);

root_redirect($GLOBALS['post_prefix_title'] . $title);

?>
