<?php

chdir( __DIR__ ) ;

require( "functions-boot-base.php" ) ;

_configBaseDebug( ) ;

_envBaseExitIfNotStatic( ) ;

////////////////////////////////////////////////////////

require( "main.php" ) ;