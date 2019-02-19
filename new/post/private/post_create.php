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

$auth_user = scrub($_POST['auth_user']);
$auth_pass = scrub($_POST['auth_pass']);
$auth_id = user_name_to_id($auth_user);

$title = scrub($_POST['title']);
$desc = scrub($_POST['desc']);
$text = scrub($_POST['text']);

// -------------------------------------

auth_enforce($auth_id, $auth_pass,
	array("contributor", "wizard", "archmage"), "make posts");

input_enforce(array($title, $desc, $text),
		array("Title", "Summary", "Text"),
		array("title", "tweet", "ne_string"));

// -------------------------------------

echo $auth_user . $auth_user_id;
post_create($title, $auth_id, $desc, $text);

root_redirect("post.php?name=" . $title);

?>
