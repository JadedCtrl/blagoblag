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

// global variable declaration
$users = user_ids();
$user = array_map(user_data, $users);
$posts = post_ids();
$post = array_map(post_data, $posts);

echo $GLOBALS['twig']->render('head.twig.html',
				['theme' => $GLOBALS['theme'],
				 'depth' => $depth,
				 'title' =>$title]);

echo $GLOBALS['twig']->render('index.twig.html', []);


echo $GLOBALS['twig']->render('foot.twig.html',
				['theme' => $GLOBALS['theme'],
				 'depth' => $depth]);

?>
