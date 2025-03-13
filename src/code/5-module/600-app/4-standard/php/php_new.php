<?php

class jj_php_new extends AppLanguage {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - definitions...
  //

  protected function define_description() : string {

    return "Create a new PHP file.";

  }

  protected function define_parameters() {

    $this->add_named_parameter( '--title', $is_optional = false );

  }

  protected function define_options() {

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - public functions...
  //

  public function run() {

    $this->print();

  }

  public function print() {

    echo <<<'EOF'
#!/usr/bin/env php
<?php

function show_help() {

}

function show_version() {

}

function main( $argv ) {

  global $g_debug, $g_interactive, $g_verbose, $g_quiet;

  error_reporting( ~0 );
  set_error_handler( 'handle_error' );

  $argv_copy = $argv;
  $command = array_shift( $argv );
  $args = [];

  $g_debug = false;
  $g_interactive = true;
  $g_verbose = false;
  $g_quiet = false;

  while ( count( $argv ) ) {

    $arg = array_shift( $argv );

    switch ( $arg ) {

    case '--help' : return show_help( $command );
    case '--version' : return show_version( $command );

    case '--debug' : $g_debug = true; break;
    case '--no-debug' : $g_debug = false; break;

    case '--interactive' : $g_interactive = true; break;
    case '--noninteractive' : $g_interactive = false; break;
    case '--non-interactive' : $g_interactive = false; break;

    case '--verbose' : $g_verbose = true; break;
    case '--quiet' : $g_quiet = true; break;

    case '--' : while ( count( $argv ) ) { $args[] = array_shift( $argv ); }; break;

    default : $args[] = $arg; break;

    }
  }

  var_dump( $args );

}

function handle_error( $errno, $errstr ) {

  throw new ErrorException( "Error $errno: $errstr" );

}

main( $argv );
EOF;

  }
}
