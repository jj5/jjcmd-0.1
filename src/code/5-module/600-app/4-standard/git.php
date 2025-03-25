<?php

class jj_git extends AppTaskGroup {


  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-25 jj5 - public static functions...
  //

  public static function add_submodule( string $url, string $path ) : void {

    $commit_message = 'Work, work...';

    if ( ! is_dir( '.git' ) ) {

      mud_fail( "not a git repo.", [ 'cwd' => getcwd() ] );

    }

    if ( is_dir( $path ) ) {

      mud_fail( "submodule already exists.", [ 'path' => $path ] );

    }

    if ( ! is_dir( 'ext' ) ) {

      $perms = fileperms( '.' );

      //$octal_perms = substr( sprintf( '%o', $perms ), -4 );

      mud_mkdir( 'ext', $perms );

    }

    $arg_url = escapeshellarg( $url );
    $arg_path = escapeshellarg( $path );
    $arg_commit_message = escapeshellarg( $commit_message );

    mud_exec( "git submodule add $arg_url $arg_path" );
    mud_exec( "git add .gitmodules $arg_path" );
    mud_exec( "git commit -m $arg_commit_message" );
    mud_exec( "git push" );
    mud_exec( "git submodule update --init --recursive" );

  }

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  // 2025-03-17 jj5 - definitions...
  //

  protected function define_category() : AppTaskCategory {

    return AppTaskCategory::Tools;

  }

  protected function define_description() : string {

    return "Operates on git repositories.";

  }

  protected function define_options() {

    $this->add_subtask( jj_git_create::class );
    $this->add_subtask( jj_git_create_bare::class );
    $this->add_subtask( jj_git_add_ext::class );

  }
}
