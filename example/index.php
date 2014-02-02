<?php

if ( file_exists('../a.php') ) {
	require '../a.php';
	if ( class_exists('A') ) {
		$path = isset($_GET['path']) ? $_GET['path'] : '';
		new A( $path );
	}
} else {
 echo "can't get A";
}
