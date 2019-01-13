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
    new A( $path );
  }
} else {
  die("Could not find A");
}
