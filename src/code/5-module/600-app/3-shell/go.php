<?php

class jj_go extends AppShell {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - mixins...
  //

  use AppFile;


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - definitions...
  //

  protected function define_category() : AppTaskCategory {

    return AppTaskCategory::Shell;

  }

  protected function define_description() : string {

    return 'Uses pushd to navigation to SPEC directory, where SPEC is an svn/git repository.';

  }

  protected function define_parameters() {

  }

  protected function define_options() {

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - constructor...
  //

  public function __construct() {

    parent::__construct();

    $this->add_sequential_parameter( 'SEARCH' );

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - public functions...
  //

  public function complete( $arg1, $arg2, $arg3, $arg4 ) {

    mud_log_trace( "complete", [ $arg1, $arg2, $arg3, $arg4 ] );

    $this->get_files( $list, $map );

    $keys = array_keys( $map );

    foreach ( $keys as $item ) {

      if ( strpos( $item, $arg2 ) === 0 ) {

        mud_stdout( $item . "\n" );

      }
    }
  }

  public function run() {

    $spec = $this->get_arg( 'SEARCH' );

    $this->get_files( $list, $map );

    $keys = array_keys( $map );

    $match = [];

    foreach ( $keys as $key ) {

      if ( $this->strpos( $key, $spec ) !== 0 ) { continue; }

      // 2022-10-03 jj5 - if it's an exact match use the first one we've found...
      //
      if ( $key === $spec ) {

        mud_stdout( $map[ $key ][ 0 ]->path . "\n" );

        return;

      }

      $match = array_merge( $match, $map[ $key ] );

    }

    if ( count( $match ) === 1 ) {

      mud_stdout( $match[ 0 ]->path . "\n" );

      return;

    }

    if ( count( $match ) === 0 ) {

      mud_stderr( "No items found for spec '$spec'.\n" );

    }

    foreach ( $match as $item ) {

      mud_stderr( $item->path . "\n" );

    }

    // 2024-11-05 jj5 - print the last match...
    //
    mud_stdout( $item->path . "\n" );

    exit( 1 );

  }
}
