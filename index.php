<?php
/**
 * Creates an instance of A
 */

if ( file_exists('a.php') ) {
  require 'a.php';
  if ( class_exists('A') ) {
    if ( ! file_exists('.htaccess') ) {
      A::generate_htaccess();
    }
    $path = isset($_GET['path']) ? $_GET['path'] : '';
    $a = new A( $path );
    $a->dispatch();
  }
} else {
  die("Could not find A");
}
