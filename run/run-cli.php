<?php

require_once __DIR__ . '/../inc/framework.php';

function app_host_cli( $argv ) {

  error_reporting( ~0 );
  set_error_handler( 'mud_handle_error' );

  try {

    mud_log_init_file( '/home/jj5/desktop/trace.log', MUD_LOG_LEVEL_7_DEBUG );

    main( $argv );

  }
  catch ( Throwable $ex ) {

    error_log( $ex->getMessage() );

    throw $ex;

  }
}

app_host_cli( $argv );
