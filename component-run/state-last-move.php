<?php



$t = scandir(_configBaseQuery( "componentcache" ));
//print_r($t);

if(count($t)>2){

    $cmd="mv "._configBaseQuery( "componentcache" )."/* "._configBaseQuery( "appcache" );

    system($cmd);

}