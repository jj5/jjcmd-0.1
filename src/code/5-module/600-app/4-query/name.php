<?php

class jj_name extends AppSearch {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - definitions...
  //

  protected function define_category() : AppTaskCategory {

    return AppTaskCategory::Search;

  }

  protected function define_description() : string {

    return "Searches for svn/git repositories which match the spec and prints out their name.";

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

  public function run() {

    $spec = $this->get_arg( 'SPEC' );

    $this->get_files( $list, $map );

    $keys = array_keys( $map );

    $match = [];

    foreach ( $keys as $key ) {

      if ( $this->strpos( $key, $spec ) !== 0 ) { continue; }

      $match = array_merge( $match, $map[ $key ] );

    }

    foreach ( $match as $item ) {

      mud_stdout( $item->name . "\n" );

    }

    $this->write_info( $list, $match );

  }
}
