<?php

/*


*/

print( "\n" ) ;


$entities = _dbBaseSelect( 1 ) ;
$totalEntities = count($entities);

$cc=0;


foreach( $entities as $e ) {


    $d = json_decode( $e[ "data" ] , true ) ;

    //_logBaseWrite( $d ) ;exit;

    $id = $e[ "id" ] ;

    $ord = $e[ "ord" ] ;

    $fp = $d[ "fs" ][ "filepath" ] ;
    $ext = $d["fs"]["ext"];

    $htimeprefix = gmdate("His", $ord);
    $htime = gmdate("Ymd", $ord);


    $targetdir = _configBaseQuery("componentcache")."/$htime" ;

    //print($targetdir."\n");

    if(!is_dir($targetdir)){

        mkdir($targetdir,0777,true);
    }

//    $cmd = "mv "._configBaseQuery( "componentcache" ) . "/$id-* $targetdir" ;
    $cmd = "mv "._configBaseQuery( "componentcache" ) . "/$id-l.$ext $targetdir/$htime-$htimeprefix-$id-l.$ext" ;
    system($cmd);
    $cmd = "mv "._configBaseQuery( "componentcache" ) . "/$id-m.$ext $targetdir/$htime-$htimeprefix-$id-m.$ext" ;
    system($cmd);
    $cmd = "mv "._configBaseQuery( "componentcache" ) . "/$id-s.$ext $targetdir/$htime-$htimeprefix-$id-s.$ext" ;
    system($cmd);
    $cmd = "mv "._configBaseQuery( "componentcache" ) . "/$id-t.$ext $targetdir/$htime-$htimeprefix-$id-t.$ext" ;
    system($cmd);
//    print("$targetdir\n"); 

    $d["prefix"]="$htime/$htime-$htimeprefix";

    //print_r($d);

    _dbBaseSetDataState($id,$d,2);

    $cc++;

    _logBaseETA($cc,$totalEntities);

} 


print( "\n" ) ; 
