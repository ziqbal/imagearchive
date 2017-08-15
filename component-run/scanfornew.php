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

if(_dbBaseContains("ABC1502627096")){
    _logBaseWrite("YKE!");
}

//_configBaseDebug();


exit;
*/




$cc = 0 ; 

$scandir=_configBaseQuery("targetdir");

$entities = _fsBaseRecursive( $scandir , "" , ".jpg" ) ;

$env = array( ) ;
$env["hn"]=_configBaseQuery("hostname");
$env["ts"]=_configBaseQuery("timestamp");

$totalEntities = count($entities);

foreach( $entities as $entity ) {

    if(substr($entity[ "filename" ],0,1)==".") continue;

    $id = sha1_file( $entity[ "filepath" ] ) ;

    if( !_dbBaseContains( $id ) ) {

        $data = array( ) ;
        $data[ "fs" ] = $entity ;
        $data[ "en" ] = $env ;
        $data[ "st" ] = stat($entity[ "filepath" ]);
        $data[ "in" ] = getimagesize($entity[ "filepath" ]);


        $exifTime = -1 ;


            $exif = @exif_read_data( $entity[ "filepath" ] , 'IFD0');

        if( $exif===false ){
        }else{ 

            $exif = @exif_read_data($entity[ "filepath" ] , 0, true);
            foreach ($exif as $key => $section) {
                foreach ($section as $name => $val) {
        //            _logBaseWrite("$key.$name:$val");
                    if("$key.$name"=="IFD0.DateTime"){
                        $exifTime=strtotime(($val));
                        //_logBaseWrite("yea[$val]");
                        break;
                    }
                }
            }
        }

        if($exifTime>0){
            $ord = $exifTime;

        }else{
            $ord = $data["st"]["mtime"];

        }

        $state = 0 ;
        _dbBaseInsert( $id, $state , $data , $ord ) ;


    }

    //print( "." ) ;

    $cc++;

    _logBaseETA($cc,$totalEntities);
    //if($cc>3) break;

}


//////////////////

$cc=0;

$entities = _fsBaseRecursive( $scandir , "" , ".jpeg" ) ;
$totalEntities = count($entities);

$env = array( ) ;
$env["hn"]=_configBaseQuery("hostname");
$env["ts"]=_configBaseQuery("timestamp");

foreach( $entities as $entity ) {

    if(substr($entity[ "filename" ],0,1)==".") continue;
    $id = sha1_file( $entity[ "filepath" ] ) ;

    if( !_dbBaseContains( $id ) ) {

        $data = array( ) ;
        $data[ "fs" ] = $entity ;
        $data[ "en" ] = $env ;
        $data[ "st" ] = stat($entity[ "filepath" ]);
        $data[ "in" ] = getimagesize($entity[ "filepath" ]);


        $exifTime = -1 ;



            $exif = @exif_read_data( $entity[ "filepath" ] , 'IFD0');


        if( $exif===false ){
        }else{ 

            $exif = @exif_read_data($entity[ "filepath" ] , 0, true);
            foreach ($exif as $key => $section) {
                foreach ($section as $name => $val) {
        //            _logBaseWrite("$key.$name:$val");
                    if("$key.$name"=="IFD0.DateTime"){
                        $exifTime=strtotime(($val));
                        //_logBaseWrite("yea[$val]");
                        break;
                    }
                }
            }
        }

        if($exifTime>0){
            $ord = $exifTime;
            //_logBaseWrite("$ord");

        }else{
            $ord = $data["st"]["mtime"];

        }



        $state = 0 ;
        _dbBaseInsert( $id, $state , $data , $ord ) ;

    }

    print( "." ) ;
    $cc++;
    _logBaseETA($cc,$totalEntities);
    //if($cc>10) break;

}

print( "\n" ) ;
