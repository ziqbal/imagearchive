
<style>

</style>

<?php

try {

    $dbh = new PDO( "sqlite:" . "../data/current.db" ) ;
    $dbh->setAttribute( PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION ) ;
    $dbh->setAttribute( PDO::ATTR_FETCH_TABLE_NAMES , true ) ;

} catch( Exception $e ) {

    _logBaseWrite( "Unable to connect" ) ;
    exit ;

}


$sql = "SELECT * FROM entities where state = :state ORDER BY ord,rowid ;" ;

$sth = $dbh->prepare( $sql , array( PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY ) ) ;
$sth->execute(array( "state" => -1 ) ) ;


$years = array( ) ;

$currentYear = "" ;

while( $row = $sth->fetch( PDO::FETCH_ASSOC ) ) {

    $ord = $row[ "ord" ] ;


    $year = date( 'Y' , $ord ) ; 

    if($currentYear==""){
        $years[]=$year;
        $currentYear=$year;
        continue;
    }

    if($currentYear!=$year){
        $years[]=$year;
        $currentYear=$year;
        continue;
    }

}

foreach($years as $year){
    print("<div><a href='year.php?y=$year'>$year</a></div>");
}
