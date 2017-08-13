<?php


function _logBase( ) {

	_logBaseWrite( date( 'l jS \of F Y h:i:s A' ) , "BOOT" , true ) ;

}

function _logBaseWrite( $msg , $key = "DEBUG" , $nl = false ) {

	if( is_array( $msg ) ) {

		$msg = "ARRAYSTART\n" . print_r( $msg , true ) ;
		
	}

	$msg = _configBaseQuery( "spid" ) . "-" . _configBaseQuery( "pid" ) . ",$key," . $msg ;

    if( $nl ) $msg = "\n" . $msg ;

	file_put_contents( _configBaseQuery( "logdir" ) . "/" . _configBaseQuery( "basename" ) . ".log" , "$msg\n" , FILE_APPEND | LOCK_EX ) ;

}
