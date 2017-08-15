<?php


$s1 = _configBaseQuery("targetdir") ;
$s2 = _configBaseQuery("appdir");

if(strlen($s1)<strlen($s2)){
    $t=$s2;
    $s2=$s1; 
    $s1=$t; 
}

if(substr($s1,0,strlen($s2))==$s2){
    print("image archive includes itself?!?!?\n");
    exit;
}



//$d=_dbBaseGet("2fb385d0f5518a9eb782455a3ac5ea56382493b0");
//print_r($d);exit;

//_configBaseDebug();exit;
//_dbBaseDebug();exit;

include( "scanfornew.php" ) ;




include( "state-0-thumbnails.php" ) ;
include( "state-1-directories.php" ) ;

include( "state-last-move.php" ) ;
