<?php

/*


*/

print( "\n" ) ;


$entities = _dbBaseSelect( 1 ) ;


foreach( $entities as $e ) {


    $d = json_decode( $e[ "data" ] , true ) ;

    //_logBaseWrite( $d ) ;exit;

    $id = $e[ "id" ] ;

    $fp = $d[ "fs" ][ "filepath" ] ;
    $ext = $d["fs"]["ext"];

    $ctime= $d["st"]["ctime"];
    $mtime= $d["st"]["mtime"];

//    $htime = gmdate("Ymd/His", $mtime);
    $htimeprefix = gmdate("His", $mtime);
    $htime = gmdate("Ymd", $mtime);


    $targetdir = _configBaseQuery("componentcache")."/$htime" ;

    //print($targetdir."\n");

    if(!is_dir($targetdir)){

        mkdir($targetdir,0777,true);
    }

//    $cmd = "mv "._configBaseQuery( "componentcache" ) . "/$id-* $targetdir" ;
    $cmd = "mv "._configBaseQuery( "componentcache" ) . "/$id-l.$ext $targetdir/$htimeprefix-$id-l.$ext" ;
    system($cmd);
    $cmd = "mv "._configBaseQuery( "componentcache" ) . "/$id-m.$ext $targetdir/$htimeprefix-$id-m.$ext" ;
    system($cmd);
    $cmd = "mv "._configBaseQuery( "componentcache" ) . "/$id-s.$ext $targetdir/$htimeprefix-$id-s.$ext" ;
    system($cmd);
    $cmd = "mv "._configBaseQuery( "componentcache" ) . "/$id-t.$ext $targetdir/$htimeprefix-$id-t.$ext" ;
    system($cmd);
//    print("$targetdir\n"); 

    $d["prefix"]="$htime/$htimeprefix";

    //print_r($d);

    _dbBaseSetDataState($id,$d,2);

    print( "." ) ;

} 


print( "\n" ) ; 
