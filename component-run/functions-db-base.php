<?php



function _dbBase( ) {


    $flagCreateTables = false ;

    $dbpath = _configBaseQuery( "datadir" ) . "/current.db" ;

    if( !file_exists( $dbpath ) ) {

        if(!is_dir(_configBaseQuery( "datadir" ))){
            mkdir(_configBaseQuery( "datadir" ));
        }

        $flagCreateTables = true ;
        
    }

    try {

        $dbh = new PDO( "sqlite:" . $dbpath) ;
        $dbh->setAttribute( PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION ) ;
        $dbh->setAttribute( PDO::ATTR_FETCH_TABLE_NAMES , true ) ;

    } catch( Exception $e ) {

        _logBaseWrite($e->getMessage());

        _logBaseWrite( "Unable to connect" ) ;
        exit ;

    }

    if( $flagCreateTables ) {

        $dbh->exec( "CREATE TABLE IF NOT EXISTS entities ( id TEXT , state INTEGER DEFAULT 0 , data BLOB , ord INTEGER DEFAULT 0 , flag INTEGER DEFAULT 0 , lum INTEGER DEFAULT 0 ) " ) ;  
        $dbh->exec( "CREATE UNIQUE INDEX IF NOT EXISTS indexid ON entities( id ) ;" ) ;
        $dbh->exec( "CREATE INDEX IF NOT EXISTS indexord ON entities( ord ) ;" ) ;
        $dbh->exec( "CREATE INDEX IF NOT EXISTS indexflag ON entities( flag ) ;" ) ;
    
    }

    /*

    try{

        $db->exec( "INSERT INTO entities( id , data ) Values( 'ABC','{}' ) ; " ) ;
    
    } catch( Exception $e ) {

        _logBaseWrite( $e ) ;
        exit ;

    }
    */

    _configBaseQuery( "dbh" , $dbh ) ;


}

function _dbBaseInsert( $id, $state , $datain , $ord ) {
//function _dbBaseInsert( $id , $datain ) {

    if(is_array($datain)){
        $data=json_encode($datain);
    }else{
        $data=$datain;
    }

    $dbh = _configBaseQuery( "dbh" ) ;

    $stmt = $dbh->prepare( "INSERT INTO entities ( id , state , data , ord ) VALUES ( :id , :state , :data , :ord) ; " ) ;

    $stmt->bindParam( ":id", $id ) ;
    $stmt->bindParam( ":state" , $state);
    $stmt->bindParam( ":data" , $data );
    $stmt->bindParam( ":ord" , $ord);


    try {

        $stmt->execute( ) ;
    
    } catch( Exception $e ) {

        _logBaseWrite( $e ) ;
        exit ;

    }

}


function _dbBaseContains( $id ) {


    $dbh = _configBaseQuery( "dbh" ) ;
    $sql = "SELECT id FROM entities where id = :id LIMIT 1;" ;

    $sth = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    $sth->execute(array("id"=>$id));

    $rows= $sth->fetchAll(PDO::FETCH_ASSOC);


    return(isset($rows[0]));


}


function _dbBaseDebug( ) {

    $dbh = _configBaseQuery( "dbh" ) ;
    $sql = "SELECT * FROM entities ;" ;

    $sth = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    $sth->execute();

    $rows= $sth->fetchAll(PDO::FETCH_ASSOC);

    _logBaseWrite($rows);

}

function _dbBaseGet($id){


    $dbh = _configBaseQuery( "dbh" ) ;
    $sql = "SELECT * FROM entities where id = :id;" ;

    $sth = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    $sth->execute(array(":id"=>$id));

    $rows= $sth->fetchAll(PDO::FETCH_ASSOC);

    return($rows);

}

function _dbBaseSelect( $state ) {

    $dbh = _configBaseQuery( "dbh" ) ;
    $sql = "SELECT * FROM entities where state = :state ;" ;

    $sth = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    $sth->execute(array("state"=>$state));

    $rows= $sth->fetchAll(PDO::FETCH_ASSOC);

    //_logBaseWrite($rows);

    return($rows);

}

function _dbBaseStateFromTo( $from , $to ) {

    $rows = _dbBaseSelect($from);
    foreach($rows as $row){
        _dbBaseStateSet($row["id"],$to);

    }


}


function _dbBaseStateSet($id,$state){

    $dbh = _configBaseQuery( "dbh" ) ;
    $sql="UPDATE entities SET  state = :state where id = :id ;"  ;
    $sth = $dbh->prepare($sql );
    $sth->execute(array(":id" => $id , ":state"=>$state));





}


function _dbBaseSetDataState($id,$datain,$state){

    if(is_array($datain)){
        $data=json_encode($datain);
    }else{
        $data=$datain;
    }

    $dbh = _configBaseQuery( "dbh" ) ;
    $sql="UPDATE entities SET  data = :data , state = :state where id = :id ;"  ;
    $sth = $dbh->prepare($sql );
    $sth->execute(array(":id" => $id , ":data" => $data , ":state"=>$state));

}