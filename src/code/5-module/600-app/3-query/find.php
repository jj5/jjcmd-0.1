<?php

class jj_find extends AppQuery {


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


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - constructor...
  //

  public function __construct() {

    parent::__construct();

    $this->add_sequential_parameter(
      'SPEC',
      'The search specification.',
    );

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

        echo $map[ $key ][ 0 ]->path;

        fwrite( STDERR, "\n" );

        return;

      }

      $match = array_merge( $match, $map[ $key ] );

    }

    if ( count( $match ) === 1 ) {

      echo $match[ 0 ]->path;

      fwrite( STDERR, "\n" );

      return;

    }

    if ( count( $match ) === 0 ) {

      fwrite( STDERR, "No items found for spec '$spec'.\n" );

    }

    foreach ( $match as $item ) {

      fwrite( STDERR, $item->path . "\n" );

    }

    // 2024-11-05 jj5 - print the last match...
    //
    echo $item->path;

    fwrite( STDERR, "\n" );

    exit( 1 );

  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - public functions...
  //

  protected function get_files( &$list, &$map ) {

    $dir = getcwd();

    mud_chdir( '/home/jj5' );

    try {

      $this->collect( 'repo', $list, $map, function( $name ) {

        return is_dir( '.svn' ) || is_dir( '.git' );

      });

      $this->collect( 'desktop', $list, $map, function( $name ) {

        return is_dir( '.svn' ) || is_dir( '.git' );

      });

    }
    finally {

      mud_chdir( $dir );

    }
  }

  protected function collect( $path, &$list, &$map, $match ) {

    static $depth = 0;

    if ( is_link( $path ) ) { return; }

    if ( ! is_dir( $path ) || $path === '.' || $path === '..' ) { return; }

    //echo str_repeat( '  ', $depth ) . "$path:\n";

    mud_chdir( $path );

    $depth++;

    if ( $match( $path ) ) {

      $item = new AppItem( $path, getcwd() );

      $list[] = $item;
      $map[ $path ][] = $item;

    }
    else {

      foreach ( scandir( '.' ) as $file ) {

        $this->collect( $file, $list, $map, $match );

      }
    }

    mud_chdir( '..' );

    $depth--;

  }

  protected function strpos( string $haystack, string $needle ) {

    if ( $needle === '' ) { return 0; }

    return strpos( $haystack, $needle );

  }
}
