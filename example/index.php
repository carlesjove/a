<?php
/**
	You can place A anywhere you want. By default, it's on the same directory as index.php
	For this example, it's placed one level down.
 */
if ( file_exists('../a.php') ) {
	require '../a.php';
	if ( class_exists('A') ) {
		$path = isset($_GET['path']) ? $_GET['path'] : '';
		new A( $path );
	}
} else {
 echo "can't get A";
}
