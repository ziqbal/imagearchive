<?php


function _fsBaseRecursiveIterator( $p ) {

	$oDirectory = new RecursiveDirectoryIterator( $p ) ;
	$oIterator = new RecursiveIteratorIterator( $oDirectory ) ;
    
	return $oIterator ;

}

// Case insensitive for pre and post
function _fsBaseRecursive( $p , $pre = "" , $post = "" ) {

	$pre = strtolower( $pre ) ;
	$post = strtolower( $post ) ;

	$preLen = strlen( $pre ) ;
	$postLen = strlen( $post ) ;

	$it = _fsBaseRecursiveIterator( $p ) ;
	$res = array( ) ;

	foreach( $it as $f ) {

	    $filename = $f->getFilename( ) ;

	    $path = $f->getPath( ) ;

	    $ext = strtolower( $f -> getExtension( ) ) ;

	    if( $pre != "" && strtolower( substr( $filename , 0 , $preLen ) ) != $pre ) continue ;
	    if( $post != "" && strtolower( substr( $filename , -$postLen ) ) != $post ) continue ;

	    if( $filename == "." ) continue ;
	    if( $filename == ".." ) continue ;

	    $res[ ] = array(

            "filepath" => $f -> getPathname( ) ,
            "filename" => $filename ,
            "path" => $path , "ext" => $ext

        ) ;

	}

	return $res ;

}



function _fsBaseCreateWritableFile( $f ) {

	if( file_exists( $f ) ) return ;

	$oldmask = umask( 0 ) ;

	$fp = fopen( $f , "w" ) ;
	fwrite( $fp , "" ) ;
	fclose( $fp ) ;
	chmod( $f , 0777 ) ; 

	umask( $oldmask ) ;		

}

function _fsBaseCopy( $a , $b ) {

	//_logBaseWrite("Copy from [$a] -> [$b]");

    $path = pathinfo( $b ) ;

    if( !file_exists( $path[ "dirname" ] ) ) {

        mkdir( $path[ "dirname" ] , 0777 , true ) ;

    }   

    if( !copy( $a , $b ) ) {

        _logBaseWrite( "copy failed " ) ;

    }

}

