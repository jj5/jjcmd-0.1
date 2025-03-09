<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2025-03-09 jj5 - load dependencies...
//

require_once __DIR__ . '/3-flags.php';


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2025-03-09 jj5 - load config file...
//

global $config;

if ( file_exists( JJCMD_CONFIG_PATH ) ) {

  require_once JJCMD_CONFIG_PATH;

}
else {

  error_log( "missing config file: " . JJCMD_CONFIG_PATH );

}

mud_define_version( 'JJCMD' );
