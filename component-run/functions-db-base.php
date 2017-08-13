<?php



function _dbBase( ) {


    $flagCreateTables = false ;

    $dbpath = _configBaseQuery( "datadir" ) . "/current.db" ;

    if( !file_exists( $dbpath ) ) {

        $flagCreateTables = true ;
        
    }

    try {

        $dbh = new PDO( "sqlite:" . $dbpath) ;
        $dbh->setAttribute( PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION ) ;
        $dbh->setAttribute( PDO::ATTR_FETCH_TABLE_NAMES , true ) ;

    } catch( Exception $e ) {

        _logBaseWrite( "Unable to connect" ) ;
        exit ;

    }

    if( $flagCreateTables ) {

        $dbh->exec( "CREATE TABLE IF NOT EXISTS entities ( id TEXT , state INTEGER , data BLOB ) " ) ;  

        $dbh->exec( "CREATE UNIQUE INDEX IF NOT EXISTS indexid ON entities( id ) ;" ) ;
    
    }

    /*

    try{

        $db->exec( "INSERT INTO entities( id , data ) Values( 'ABC','{}' ) ; " ) ;
    
    } catch( Exception $e ) {

        _logBaseWrite( $e ) ;
        exit ;

    }
    */

    _configBaseQuery("dbh",$dbh);


}

function _dbBaseInsert( $id , $datain ) {

    if(is_array($datain)){
        $data=json_encode($datain);
    }else{
        $data=$datain;
    }

    $dbh = _configBaseQuery( "dbh" ) ;

    $stmt = $dbh->prepare( "INSERT INTO entities ( id , state , data ) VALUES ( :id , 0 , :data ) ; " ) ;

    $stmt->bindParam( ":id", $id ) ;
    $stmt->bindParam( ":data" , $data );


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