<?php
$title = "Estic fent un llistat";
$body = "I have an array named after me in <code>data/list.php</code>.<br><br>"
. "Here's what it looks like:<br><br>"
."<pre><code>"
.'
$list = array(
	\'first-item\' => array(
		\'title\' => \'My first item\',
		),
	\'item-2\' => array(
		\'title\' => \'My second item\',
		),
	);
'."</code></pre>";
$after_body = "Since this file is called <code>list.php</code>, 
the view template for items is called <code>list_[id].php</code>.<br>
Items keys will be searched for URL matches.<br><br>
Here I'm turning them into links:<br><br>";

$list = array(
	'first-item' => array(
		'title' => 'Sóc el primer element',
		),
	'item-2' => array(
		'title' => 'El segon element',
		),
	);