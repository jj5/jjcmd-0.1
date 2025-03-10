<?php

require_once __DIR__ . '/../inc/framework.php';

function app_host_cli( $argv ) {

  error_reporting( ~0 );
  set_error_handler( 'mud_handle_error' );

  try {

    main( $argv );

  }
  catch ( Throwable $ex ) {

    error_log( $ex->getMessage() );

    throw $ex;

  }
}

app_host_cli( $argv );
