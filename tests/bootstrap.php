<?php

// The path to wordpress-tests
// Path to wordpress unit test framework
$path = '/src/wp_unit/bootstrap.php';

if( file_exists( $path ) ) {
    require_once $path;
} else {
    exit( "Couldn't find path to bootstrap.php\n" );
}