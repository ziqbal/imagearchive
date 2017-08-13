<?php

if( php_sapi_name( ) != "cli" )  exit ;

require( "functions-config-base.php" ) ;
require( "functions-log-base.php" ) ;
require( "functions-util-base.php" ) ;
require( "functions-fs-base.php" ) ;
require( "functions-db-base.php" ) ;

_bootBase( ) ;

function _bootBase( ) {

	date_default_timezone_set( "UTC" ) ;

	_configBase( ) ;
	_logBase( ) ;
    _dbBase( ) ;

}

