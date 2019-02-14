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
// post environment
$post_id = $_GET['id'];
$text = post_text($post_id);
$author = post_author($post_id);
$date = post_data($post_id);
// -------------------------------------

echo $GLOBALS['twig']->render('head.twig.html',
				['theme' => $GLOBALS['theme'],
				 'depth' => $depth,
				 'title' =>$title]);

echo $GLOBALS['twig']->render('post.twig.html',
				 ['id'=> $post_id,
				  'text' => $text,
				  'author' => $author,
				  'date' => $date]);


echo $GLOBALS['twig']->render('foot.twig.html',
				['theme' => $GLOBALS['theme'],
				 'depth' => $depth]);

?>
