<?php
ini_set ( 'display_errors', 1 );
ini_set ( 'display_startup_errors', 1 );
error_reporting ( E_ALL );

defined ( "DATABASE_PATH" ) or define ( "DATABASE_PATH", str_replace('\\', '/', realpath ( dirname(__FILE__) . '/database' )) );
defined ( "INCLUDES_PATH" ) or define ( "INCLUDES_PATH", str_replace('\\', '/', realpath ( dirname(__FILE__) . '/includes' )) );
defined ( "TEMPLATES_PATH" ) or define ( "TEMPLATES_PATH", str_replace('\\', '/', realpath ( dirname(__FILE__) . '/templates' )) );
?>