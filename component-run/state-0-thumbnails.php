<?php

/*


square 150x150 22500
small 240x180 43200 
medium 640x480 307200
large 1024x768 786432

square 150x150 22500
small 90000
medium 360000
large 1440000


*/

$cc=0;

$entities = _dbBaseSelect( 0 ) ;



foreach( $entities as $e ) {


    $d = json_decode( $e[ "data" ] , true ) ;

    //_logBaseWrite( $d ) ;exit;

    $id=$e["id"];

    $fp = $d["fs"]["filepath"];
    $ext = $d["fs"]["ext"];
    $w  = $d["in"][0];
    $h  = $d["in"][1];

    $ar = $w/$h ;

    //_logBaseWrite("$fp $w,$h");

    $source = $fp ;
    $target = _configBaseQuery("componentcache") . "/$id-l.$ext" ;
    $source=escapeshellarg($source);
    $target=escapeshellarg($target);
    $cmd = "convert $source -sampling-factor 1x1 -unsharp 1.5x1+0.7+0.02 -auto-orient -filter Lanczos -quality 85 -thumbnail x1200 $target" ;
//    _logBaseWrite($cmd);
    system($cmd);

    $source = _configBaseQuery("componentcache") . "/$id-l.$ext" ;
    $target = _configBaseQuery("componentcache") . "/$id-m.$ext" ;
    $source=escapeshellarg($source);
    $target=escapeshellarg($target);
    $cmd = "convert $source -filter Lanczos -quality 80 -thumbnail x600 $target" ;
//    _logBaseWrite($cmd);
    system($cmd);

    $source = _configBaseQuery("componentcache") . "/$id-m.$ext" ;
    $target = _configBaseQuery("componentcache") . "/$id-s.$ext" ;
    $source=escapeshellarg($source);
    $target=escapeshellarg($target);
    $cmd = "convert $source -filter Lanczos -quality 80 -thumbnail x300 $target" ;
//    _logBaseWrite($cmd);
    system($cmd);

    $source = _configBaseQuery("componentcache") . "/$id-s.$ext" ;
    $target = _configBaseQuery("componentcache") . "/$id-t.$ext" ;
    $source=escapeshellarg($source);
    $target=escapeshellarg($target);
    $cmd="convert $source -filter Lanczos -quality 80 -thumbnail 150x150^ -gravity center -extent 150x150 $target";

    //-sampling-factor 1x1 -unsharp 1.5x1+0.7+0.02 -quality 90
//    _logBaseWrite($cmd);
    system($cmd);



    _dbBaseStateSet($id,1);

    print("!");

    $cc++;
    //if($cc>10) break;
} 


print("\n");
