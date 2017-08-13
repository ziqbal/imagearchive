<?php

function _envBase( ) {

}

function _envBaseInStatic( ) {

	if( strpos( _configBaseQuery( "scriptdir" ) , "/_static_/" ) === false ) {

		_logBaseWrite( "NOT STATIC!!" ) ;
		return( false ) ;

	}	
	
	return( true ) ;

}

function _envBaseExitIfNotStatic( ) {

	if( !_envBaseInStatic( ) ) {

		_logBaseWrite( "NOT STATIC!!" ) ;
		exit ;
	}	

}

function _envBaseGetAllPageFilenames( ) {

	$allpages = array( ) ;
	
	$allfiles = scandir( _configBaseQuery( "templates" ) ) ;

	foreach( $allfiles as $file ) {

		if( substr( $file , -9 ) == ".old.html" ) continue;
		if( substr( $file , -5 ) == ".html" ) $allpages[ ] = $file ;

	}

	return( $allpages ) ;
}