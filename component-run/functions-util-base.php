<?php

// get actual files form data files
// filter by modification time
function _utilBaseGetAllFormJsonFiles( ) {

	$allfiles = scandir( _configBaseQuery( "uicache") ) ;

	$allforms = array( ) ;

	$timeNow = time( ) ;

	foreach( $allfiles as $afv ) {

		$prematch = "form-" ;
		$postmatch = ".json" ;

		if( substr( $afv , 0 , strlen( $prematch))==$prematch){

			if( substr( $afv , -strlen( $postmatch ) ) == $postmatch ) {

				$allformsPath = _configBaseQuery( "uicache" )."/$afv" ;

				$dtime = $timeNow - filemtime( $allformsPath ) ;

	            if( $dtime > 3 ) {

	                $allforms[ $allformsPath ] = json_decode(file_get_contents( $allformsPath ),true);

	            }

			}


		}

	}	

	return($allforms);

}


function _utilBaseFilterFormsByKeyVal( $forms , $key , $val ) {

	$matchedforms = array( ) ;

	foreach( $forms as $alfk => $alfv ) {

	    //_logBaseWrite( $alfk );

		$allformdata = json_decode( base64_decode( $alfv[ 'post' ][ '_' ] ) , true ) ;

		$formdata = $allformdata[ 'fo' ] ;

		//_logBaseWrite($formdata);

		foreach( $formdata as $fdv ) {

			if( ( $fdv[ 'name' ] == $key  ) && ( $fdv[ 'value' ] == $val ) ) {

	            $matchedforms[ $alfk ] = $alfv ;

				continue ;

			}
			
		}

	}

	return($matchedforms);

}

function _utilBaseFilterLatest( $forms ) {

	$latestmap = array( ) ;

	foreach( $forms as $ak => $av ) {

	    $allformdata = json_decode( base64_decode( $av[ 'post' ][ '_' ] ) , true ) ;

	    $formdata = $allformdata[ 'fo' ] ;

	    foreach( $formdata as $fdv ) {

	        if( $fdv[ 'name' ] == "form_stamp" ) {

	            $mtime = filemtime( $ak ) ;
	            //_logBaseWrite($mtime);
	            //_logBaseWrite($fdv[ 'value' ]);

	            if(isset($latestmap[$fdv[ 'value' ]])){

	                $currentData =  $latestmap[$fdv[ 'value' ]];
	                if($mtime>$currentData[1]){
	                    $latestmap[$fdv[ 'value' ]]=array($ak,$mtime);

	                }

	            }else{


	                $latestmap[$fdv[ 'value' ]]=array($ak,$mtime);

	            }

	            continue ;

	        }
	        
	    }    

	}

	$filteredForms = array( ) ;

	foreach($latestmap as $lk=>$lv){

	    $filteredForms[$lv[0]]=$forms[$lv[0]];

	}

	return($filteredForms);

}

function _utilBaseExtractFormData( $forms ) {

	$formsdata = array( ) ;

	foreach( $forms as $fk => $fv ) {

	    $allformdata = json_decode( base64_decode( $fv[ 'post' ][ '_' ] ) , true ) ;

	    $formsdata[ $fk ] = $allformdata[ 'fo' ] ;

	}

	return( $formsdata ) ;

}

function _utilBaseGetValueByName( $data , $name ) {

	foreach( $data as $dv ) {

		if( $dv[ 'name' ] == $name ) return( $dv[ 'value' ] ) ;

	}

	return( NULL ) ;

}

