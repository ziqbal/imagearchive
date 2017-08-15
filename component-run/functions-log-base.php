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


$_LOGETALASTTIME_=-1;
function _logBaseETA($cc,$total){

    global $_LOGETALASTTIME_;

    if($cc==0){
        $_LOGETALASTTIME_=-1;
    }

    if($_LOGETALASTTIME_==-1) {
        $_LOGETALASTTIME_=time();
    }

    if(($cc%10)==0){
        $p=round(($cc/$total)*100);
        $t=time()-$_LOGETALASTTIME_;

        if($p>0){
            $trem=round(($t/$p)*100)-$t;
        }else{
            $trem=0;
        }

        $hrt=_utilBaseSec2hms($t);
        $hrtrem=_utilBaseSec2hms($trem);
        print("[$hrt][$p%][$hrtrem] $cc/$total\n");
    }


}
