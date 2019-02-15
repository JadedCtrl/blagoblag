<?php
/* This file is free software: you can redistribute it and/or modify
   it under the terms of version 3 of the GNU Affero General Public
   License as published by the Free Software Foundation.

   This file is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU Affero General Public License for more details. */

$depth = "";
$title = "";
include "res/lib/load.php";

// -------------------------------------

$id = $_GET['id'];
$text = post_text($id);
$author = post_author($id);
$date = post_data($id);

$local_exports = array('id' => $id, 'text' => $text, 'author' => $author,
			'data' => $data);

// -------------------------------------

display_page("post.twig.html", $depth, $title, $local_exports);

?>
