
<style>
.thumbnail{
    height:100px;
    border:0px solid green;
    padding:3px;
    margin:1px;
}
.c3{
    background-color: #ff0000;
}
.c4{
    background-color: #fff000;
}
</style>

<?php

try {

    $dbh = new PDO( "sqlite:" . "../data/current.db") ;
    $dbh->setAttribute( PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION ) ;
    $dbh->setAttribute( PDO::ATTR_FETCH_TABLE_NAMES , true ) ;

} catch( Exception $e ) {

    _logBaseWrite( "Unable to connect" ) ;
    exit ;

}


//$sql = "SELECT * FROM entities where state = :state ORDER BY rowid limit 250;" ;
$sql = "SELECT * FROM entities where state = :state ORDER BY ord,rowid limit 250;" ;

$sth = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
$sth->execute(array("state"=>2));



$lastPrefixMain="";

$cc=0;
while($row = $sth->fetch( PDO::FETCH_ASSOC )){ 
    $id=$row["id"];
    $d = json_decode( $row[ "data" ] , true ) ;
    $prefix=$d["prefix"];
    $ext = $d["fs"]["ext"];

    $prefixParts=explode("/",$prefix);

    $prefixMain=$prefixParts[0];

    if($lastPrefixMain==""){
        print("$prefixMain<br/>");
        $lastPrefixMain=$prefixMain;
    }
    if($lastPrefixMain!="" && $lastPrefixMain!=$prefixMain){
        print("<br/>$prefixMain<br/>");
        $lastPrefixMain=$prefixMain;
    }


    print("<img class='thumbnail c$cc' src='../_cache_/$prefix-$id-t.$ext'/>");
    $cc++;
}


