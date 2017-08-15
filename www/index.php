<?php
// Days
$inputLimit = 60 ;
$inputOffset = 0 ;

if(isset($_GET[ "limit" ])) $inputLimit = $_GET[ "limit" ] ;
if(isset($_GET[ "offset" ])) $inputOffset = $_GET[ "offset" ] ;

$nextOffset = $inputOffset + $inputLimit ;

try {

    $dbh = new PDO( "sqlite:" . "../data/current.db" ) ;
    $dbh->setAttribute( PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION ) ;
    $dbh->setAttribute( PDO::ATTR_FETCH_TABLE_NAMES , true ) ;

} catch( Exception $e ) {

    _logBaseWrite( "Unable to connect" ) ;
    exit ;

}

$sql = "SELECT * FROM entities where state = :state ORDER BY ord LIMIT :limit OFFSET :offset ;" ;
$sth = $dbh->prepare( $sql , array( PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY ) ) ;
$sth->execute( array( "state" => -1 , "limit" => $inputLimit,"offset" => $inputOffset)  );

?>

<style>
.thumbnail{
    height:100px;
    border:0px solid green;
    padding:3px;
    margin:1px;
}

</style>

<?php

print("<a href='?offset=0'>START<a>");
print("&nbsp;");
print("<a href='?offset=$nextOffset'>NEXT<a>");

print("<br/>");

while( $row = $sth->fetch( PDO::FETCH_ASSOC ) ) {

    $id=$row["id"];
    $d = json_decode( $row[ "data" ] , true ) ;
    $prefix=$d["prefix"];
    $ext = $d["fs"]["ext"];

    print("<a href='../_cache_/$prefix-$id-l.$ext'><img class='thumbnail c$cc' src='../_cache_/$prefix-$id-t.$ext'/></a>");

}
