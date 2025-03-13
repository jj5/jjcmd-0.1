<?php

class jj_find extends AppStandard {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - definitions...
  //

  protected function define_category() : AppTaskCategory{

    return AppTaskCategory::Search;

  }

  protected function define_description() : string {

    return "Searches for svn/git repositories which match the spec. If there is an exact match or only one " .
      "match the full path is listed on stdout, otherwise the list of matches (if any) is printed to " .
      "stderr. See 'jj name' and 'jj path' for alternative.";

  }

  protected function define_parameters() {

    $this->add_sequential_parameter( 'SPEC' );

  }

  protected function define_options() {

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-13 jj5 - mixins...
  //

  use AppFile;


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

      // 2022-10-03 jj5 - if it's an exact match use the first one we've found...
      //
      if ( $key === $spec ) {

        mud_stdout( $map[ $key ][ 0 ]->path );

        mud_stderr( "\n" );

        return;

      }

      $match = array_merge( $match, $map[ $key ] );

    }

    if ( count( $match ) === 1 ) {

      mud_stdout( $match[ 0 ]->path );

      mud_stderr( "\n" );

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
    mud_stdout( $item->path );

    mud_stderr( "\n" );

    exit( 1 );

  }
}
