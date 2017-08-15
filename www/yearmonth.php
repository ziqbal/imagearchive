<?php

$inputYear = $_GET["y"] ;
$inputMonth = $_GET["m"] ;

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
$sth->execute( array( "state" => -1 ) ) ;

?>

<style>

</style>

<?php


$months=array();

$currentMonth="";

while( $row = $sth->fetch( PDO::FETCH_ASSOC ) ) {

    $ord = $row[ "ord" ] ;

    $year = date( 'Y' , $ord ) ; 

    if($inputYear!=$year) continue;

    $month = date( 'F' , $ord ) ; 

    if($currentMonth==""){
        $months[]=$month;
        $currentMonth=$month;
        continue;
    }

    if($currentMonth!=$month){
        $months[]=$month;
        $currentMonth=$month;
        continue;
    }


}

print("<h1>$year</h1>");

foreach($months as $month){
    print("<div><a href='yearmonth.php?y=$year&m=$month'>$month</a></div>");
}
