<?php
/* 
Plugin Name: WP Plugin Template
Description: This is a WordPress plugin template
Author: Your Name
Version: 0.1
*/

if ( preg_match( '#' . basename( __FILE__ ) . '#', $_SERVER['PHP_SELF'] ) ) {
    die( 'You are not allowed to call this page directly.' );
}

require_once 'src/plugin.php';