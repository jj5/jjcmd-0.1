<?php

trait AppFile {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-12 jj5 - protected functions...
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

  protected function write_info( $list, $match ) {

    mud_stderr( "\n" );
    mud_stderr( "list...: " . count( $list ) . "\n" );
    mud_stderr( "match..: " . count( $match ) . "\n" );

  }
}