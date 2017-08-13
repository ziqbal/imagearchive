<?php

// 293MB 4616 files
// 104MB 2501
// 96MB 2477

//chdir( "../../" ) ;


/*

$id = "ABC".time() ;

$data = array( ) ;
$data[ "w" ] = 1024 ;
$data[ "h" ] = 640 ;
$data[ "rnd" ] = mt_rand(0,9999999);


_dbBaseInsert( $id , $data ) ;
_dbBaseDebug();
*/


_configBaseDebug();


$scandir=_configBaseQuery("targetdir");

$entities = _fsBaseRecursive( $scandir , "" , "jpg" ) ;

foreach( $entities as $entity ) {

    
}
_logBaseWrite($entities);