<?php

function _mathBaseGetEmptyMarkers( $refarray ) {

	$res = array( ) ;


	foreach($refarray as $k=>$v){
		$res[$k]=0;
	}



	return($res);


}