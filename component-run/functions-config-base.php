<?php

$_CONFIG_ = array( ) ;

function _configBase( ) {

	_configBaseInit( ) ;
	
}

function _configBaseInit( ) {

	global $argv ;

	_configBaseQuery( "pid" , getmypid( ) ) ;
	_configBaseQuery( "originalargs" , $argv ) ;
	_configBaseQuery( "targetdir" , $argv[ 1 ] ) ;
	_configBaseQuery( "hostname" , $argv[ 2 ] ) ;
	_configBaseQuery( "timestamp" , $argv[ 3 ] ) ;
	_configBaseQuery( "spid" , $argv[ 4 ] ) ;
	_configBaseQuery( "componentdir" , __DIR__ ) ;
    _configBaseQuery( "appdir" , realpath(__DIR__."/..") ) ;
    _configBaseQuery( "logdir" , "/tmp" ) ;
	_configBaseQuery( "basename" , basename( __DIR__ ) ) ;

	_configBaseQuery( "appcache" , _configBaseQuery( "appdir" ) . "/_cache_" ) ;
    _configBaseQuery( "componentcache" , _configBaseQuery( "componentdir" ) . "/_cache_" ) ;

    _configBaseQuery( "datadir" , _configBaseQuery( "appdir" ) . "/data" ) ;

	if( ! file_exists( _configBaseQuery( "componentcache" ) ) ) {

		mkdir( _configBaseQuery( "componentcache" ) ) ;
		chmod( _configBaseQuery( "componentcache" ) , 0777 ) ;

	}

    if( ! file_exists( _configBaseQuery( "appcache" ) ) ) {

        mkdir( _configBaseQuery( "appcache" ) ) ;
        chmod( _configBaseQuery( "appcache" ) , 0777 ) ;

    }

}

function _configBaseDebug( ) {

	global $_CONFIG_ ;

	print_r( $_CONFIG_ ) ;

}

function _configBaseQuery(  ) {

	global $_CONFIG_ ;

	$args = func_get_args( ) ;

	if( count( $args ) == 1 ) {

		if( !isset( $_CONFIG_[ $args[ 0 ] ] ) ) {

			return( NULL ) ;

		} else {

			return( $_CONFIG_[ $args[ 0 ] ] ) ;

		}

	}

	$_CONFIG_[ $args[ 0 ]  ] = $args[ 1 ]  ;

} 

