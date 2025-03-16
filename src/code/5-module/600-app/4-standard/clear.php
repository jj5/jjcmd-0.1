<?php

class jj_clear extends AppStandard {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - definitions...
  //

  protected function define_category() : AppTaskCategory {

    return AppTaskCategory::Tools;

  }

  protected function define_description() : string {

    return "Clears an item from the cache.";

  }

  protected function define_parameters() {

    $this->add_sequential_parameter( 'SEARCH' );

  }

  protected function define_options() {

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - constructor...
  //

  public function __construct() {

    parent::__construct();

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - public functions...
  //

  public function complete( $arg1, $arg2, $arg3, $arg4 ) {

    app()->get_cache( null, $data );

    $keys = array_keys( $data[ 'cache' ] );

    foreach ( $keys as $key ) {

      if ( strpos( $key, $arg2 ) === 0 ) {

        mud_stdout( "$key\n" );

      }
    }
  }

  public function run() {

    $spec = $this->get_arg( 'SEARCH' );

    app()->clear_cache( $spec );

  }
}
