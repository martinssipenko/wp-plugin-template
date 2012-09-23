<?php

require_once 'plugin-template.php';

class TemplatePluginTest extends WP_UnitTestCase {
    public function setUp() {
        parent::setUp();
        $this->plugin = $GLOBALS['template_plugin'];
    }

    function testPluginInitialization() {  
        $this->assertFalse( null == $this->plugin );  
    }
}
