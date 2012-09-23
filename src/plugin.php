<?php

if ( preg_match( '#' . basename( __FILE__ ) . '#', $_SERVER['PHP_SELF'] ) ) {
	die( 'You are not allowed to call this page directly.' );
}

class Template_Plugin {
    /**
     * Setup our filters
     *
     * @return void
     */
	public function __construct() {
		add_filter( 'the_content', array( $this, 'append_content' ) );
	}

	/**
	 * Appends "Hello WordPress Unit Tests" to the content of every post
	 *
	 * @param string $content
	 * @return string
	 */
	public function append_content( $content ) {
		return $content . '<p>Hello WordPress Unit Tests</p>';
	}
}

$GLOBALS['template_plugin'] = new Template_Plugin();