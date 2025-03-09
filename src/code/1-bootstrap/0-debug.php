<?php


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 2025-03-09 jj5 - load debug definitions...
//

(function() {

  // 2024-07-07 jj5 - NOTE: we load the debug config file here, if it exists. This is so that we can get access to
  // DEBUG and DEV constants while we are loading...

  $app_dir = realpath( __DIR__ . '/../../../' );
  $app_debug = $app_dir . '/debug.php';

  if ( file_exists( $app_debug ) ) {

    require_once $app_debug;

  }
  else {

    define( 'DEBUG', false );
    define( 'DEV', false );
    define( 'BETA', false );
    define( 'PROD', false );

  }

  assert( defined( 'DEBUG' ) );
  assert( defined( 'DEV' ) );
  assert( defined( 'BETA' ) );
  assert( defined( 'PROD' ) );

})();
