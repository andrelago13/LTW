<?php
ini_set ( 'display_errors', 1 );
ini_set ( 'display_startup_errors', 1 );
error_reporting ( E_ALL );

$dirnameFILE = str_replace('\\', '/', dirname(__FILE__));

defined ( "DATABASE_PATH" ) or define ( "DATABASE_PATH", realpath ( $dirnameFILE . '/database' ) );
defined ( "INCLUDES_PATH" ) or define ( "INCLUDES_PATH", realpath ( $dirnameFILE . '/includes' ) );
defined ( "TEMPLATES_PATH" ) or define ( "TEMPLATES_PATH", realpath ( $dirnameFILE . '/templates' ) );
?>