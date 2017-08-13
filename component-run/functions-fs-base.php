<?php


function _fsBaseRecursiveIterator($p){
	$oDirectory = new RecursiveDirectoryIterator($p);
	$oIterator = new RecursiveIteratorIterator($oDirectory);
	return $oIterator;
}

// Case insensitive for pre and post
function _fsBaseRecursive( $p , $pre = '' , $post = '' ) {

	$pre=strtolower($pre);
	$post=strtolower($post);

	$preLen = strlen( $pre ) ;
	$postLen = strlen( $post ) ;

	$it = _fsBaseRecursiveIterator( $p ) ;
	$res = array( ) ;

	foreach( $it as $f ) {

	    $filename = $f->getFilename( ) ;

	    $path = $f->getPath( ) ;

	    $ext=strtolower($f->getExtension());

	    if($pre!='' && strtolower(substr($filename,0,$preLen))!=$pre) continue;
	    if($post!='' && strtolower(substr($filename,-$postLen))!=$post) continue;
	    if($filename=='.') continue;
	    if($filename=='..') continue;
	    $res[]=array('pathname'=>$f->getPathname(),'filename'=>$filename,'path'=>$path,'ext'=>$ext);
	}
	return $res;
}



function _fsBaseCreateWritableFile($f){
	if(file_exists($f)) return;

	$oldmask = umask(0);

	$fp = fopen($f, 'w');
	fwrite($fp, "");
	fclose($fp);
	chmod($f, 0777); 

	umask($oldmask);		

}

function _fsBaseGetAllFilesRelativeToStaticPath( $dbpath ) {


	$staticPath = _configBaseQuery( "templates" ) ;
	$staticPathLen = strlen($staticPath);


	$absPath = $staticPath . "/" . $dbpath ;


	$allfiles = _fsBaseRecursive( $absPath ) ;



	$dbfiles = array();

	foreach( $allfiles as $afv ) {


	/*
	Array
	(
	    [pathname] => /Applications/XAMPP/xamppfiles/htdocs/_craft_/_static_/_dangerousbend_/ultrasine2/template-submit.html
	    [filename] => template-submit.html
	    [path] => /Applications/XAMPP/xamppfiles/htdocs/_craft_/_static_/_dangerousbend_/ultrasine2
	    [ext] => html
	)
	*/	

		$pathname = substr($afv[ "pathname" ] ,$staticPathLen+1);

		//_logBaseWrite( $pathname ) ;

		$dbfiles[]=$pathname;


	}	

	return($dbfiles);


}


function _fsBaseGetCacheTemplateFilesRelativeToStaticPath( $dbpath ) {


	$staticPath = _configBaseQuery( "templates" ) ;
	$staticPathLen = strlen($staticPath);


	$absPath = $staticPath . "/" . $dbpath ;


	$allfiles = _fsBaseRecursive( $absPath ) ;



	$dbfiles = array();

	foreach( $allfiles as $afv ) {


	/*
	Array
	(
	    [pathname] => /Applications/XAMPP/xamppfiles/htdocs/_craft_/_static_/_dangerousbend_/ultrasine2/template-submit.html
	    [filename] => template-submit.html
	    [path] => /Applications/XAMPP/xamppfiles/htdocs/_craft_/_static_/_dangerousbend_/ultrasine2
	    [ext] => html
	)
	*/	

		$pathname = substr($afv[ "pathname" ] ,$staticPathLen+strlen($dbpath)+ 2);

		$pathnameparts = explode("/",$pathname);
		if(count($pathnameparts)!=4){
			continue;
		}
		//$pathname = $afv[ "filename" ] ;

		//_logBaseWrite( $pathname ) ;

		$dbfiles[]=$pathname;


	}	

	return($dbfiles);


}



function _fsBaseGetHtmlFilesRelativeToStaticPath( ) {

	$tdir = _configBaseQuery( "templates" ) ;

	$allfiles = scandir( $tdir ) ;

	$files = array( ) ;


	foreach( $allfiles as $afv ) {

		$postmatch = ".html" ;

		if( substr( $afv , -strlen( $postmatch ) ) == $postmatch ) {

			$files[]=$afv;


		}

	}


	return($files);




}


function _fsBaseCopy( $a , $b ) {

	//_logBaseWrite("Copy from [$a] -> [$b]");

    $path = pathinfo($b);
    if (!file_exists($path['dirname'])) {
        mkdir($path['dirname'], 0777, true);
    }   
    if (!copy($a,$b)) {
        _logBaseWrite("copy failed ");
    }


}


