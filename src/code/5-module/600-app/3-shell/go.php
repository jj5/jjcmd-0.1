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

    if ( $spec === null ) {

      return $this->print_options();

    }

    if ( $spec === 'new' ) {

      $new_path = $this->get_new_path();

      //mud_stderr( "new: $new_path\n" );

      if ( is_dir( $new_path ) ) {

        mud_stdout( "$new_path\n" );

        exit( 0 );

      }
      else {

        mud_stderr( "missing path: $new_path\n" );

        exit( 1 );

      }
    }

    $path = app()->get_cache( $spec );

    if ( ! $path ) {

      $path = $this->get_path( $spec );

    }

    if ( $path ) {

      app()->set_cache( $spec, $path );

      mud_stdout( "$path\n" );

      exit( 0 );

    }
    else {

      mud_stderr( "no items found for spec: $spec\n" );

      exit( 1 );

    }
  }


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-16 jj5 - protected functions...
  //

  protected function print_options() {

    $new_path = $this->get_new_path();

    if ( $new_path ) {

      mud_stderr( "new: $new_path\n" );

    }

    $this->print_cache();

  }

  protected function print_cache() {

    $cache = app()->get_cache( null, $data );

    foreach ( $data[ 'cache' ] as $spec => $path ) {

      mud_stderr( "$spec: $path\n" );

    }
  }

  protected function get_new_path() : ?string {

    $home_dir = getenv( 'HOME' );

    if ( ! is_dir( $home_dir ) ) {

      mud_fail( "missing home directory: $home_dir", [ 'class' => get_called_class() ] );

    }

    $config_dir = "$home_dir/.config/jjcmd";

    if ( ! is_dir( $config_dir ) ) {

      mud_mkdir( $config_dir, 0755 );
    }

    $new_path_file = "$config_dir/new-path.txt";

    if ( file_exists( $new_path_file ) ) {

      return trim( file_get_contents( $new_path_file ) );

    }

    return null;

  }

  protected function get_path( string $spec ) {

    $this->get_files( $list, $map );

    $keys = array_keys( $map );

    $match = [];

    foreach ( $keys as $key ) {

      if ( $this->strpos( $key, $spec ) !== 0 ) { continue; }

      // 2022-10-03 jj5 - if it's an exact match use the first one we've found...
      //
      if ( $key === $spec ) {

        return $map[ $key ][ 0 ]->path;

      }

      $match = array_merge( $match, $map[ $key ] );

    }

    if ( count( $match ) === 0 ) {

      return null;

    }

    foreach ( $match as $item ) {

      mud_stderr( $item->path . "\n" );

    }

    // 2025-03-16 jj5 - matches will be sorted by date with more recent first, so return the first one...
    //
    return $match[ 0 ]->path;

  }
}
